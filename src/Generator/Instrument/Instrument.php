<?php
namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Effect\Effect;
use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Utils\Envelope;
use Synthesizer\Generator\Instrument\Utils\NotesFrequencies;
use Synthesizer\Time\Clock;

abstract class Instrument
{
    /** @var Generator[] */
    private array $keys;
    /** @var Envelope[] */
    private array $keysDown = [];
    protected Clock $clock;
    /** @var array<Envelope> */
    protected array $keysReleased = [];

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;

        $this->initializeKeys();
    }

    public function getValue() : float
    {
        $value = 0;

        foreach ($this->keysDown as $key => $generator) {
            $value += $generator->getValue();

            if ($generator->isOver()) {
                unset($this->keysDown[$key]);
            }
        }

        foreach ($this->keysReleased as $key => $generator) {
            $value += $generator->getValue();

            if ($generator->isOver()) {
                unset($this->keysReleased[$key]);
            }
        }

        return $value;
    }

    public function isOver() : bool
    {
        return count($this->keysDown) + count($this->keysReleased) == 0;
    }

    public function keyDown(string $key) : void
    {
        if (!isset($this->keys[$key])) {
            throw new \InvalidArgumentException(sprintf('Unknown note "%s"', $key));
        }

        if (isset($this->keysDown[$key])) {
            $this->keyUp($key);;
        }

        $this->keysDown[$key] = $this->getEnvelope($this->keys[$key]);
        $this->keysDown[$key]->noteOn();
    }

    public function keyUp(string $key) : void
    {
        if (!isset($this->keysDown[$key])) {
            return;
        }

        $this->keysDown[$key]->noteOff();
        $this->keysReleased[] = $this->keysDown[$key];

        unset($this->keysDown[$key]);
    }

    public function keyUpAll() : void
    {
        foreach ($this->keysDown as $key => $none) {
            $this->keyUp($key);
        }
    }

    private function initializeKeys() : void
    {
        foreach (NotesFrequencies::FREQUENCIES as $key => $frequency) {
            $this->keys[$key] = $this->initializeKey($frequency);
        }
    }

    protected function getEnvelope(Generator $generator) : Envelope
    {
        return new Envelope($generator, $this->clock);
    }

    protected abstract function initializeKey(float $frequency) : Generator;
}
