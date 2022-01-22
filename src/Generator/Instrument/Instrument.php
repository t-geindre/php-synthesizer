<?php
namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Effect\Effect;
use Synthesizer\Generator\Instrument\Effect\Envelope;
use Synthesizer\Generator\Instrument\Effect\VoidEffect;
use Synthesizer\Generator\Instrument\Reference\NotesFrequencies;
use Synthesizer\Time\Clock;

abstract class Instrument implements Generator
{
    /** @var Generator[] */
    private array $keys;
    /** @var Envelope[] */
    private array $keysDown = [];
    private Clock $clock;
    /** @var array<Envelope> */
    private array $keysReleased = [];
    private bool $isSustainOn = false;
    /** @var array<Envelope> */
    private array $sustainedKeys = [];

    const VELOCITY_MAX = 127;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;

        $this->initializeKeys();
    }

    public function getValue() : float
    {
        if (!$this->isSustainOn) {
            foreach ($this->sustainedKeys as $key => $generator) {
                $generator->noteOff();
                $this->keysReleased[] = $generator;
                unset($this->sustainedKeys[$key]);
            }
        }

        $value = 0;

        foreach ([
            &$this->keysDown,
            &$this->keysReleased,
            &$this->sustainedKeys
        ] as &$generators) {
            foreach ($generators as $key => $generator) {
                $value += $generator->getValue();

                if ($generator->isOver()) {
                    unset($generators[$key]);
                }
            }
        }

        return $value;
    }

    public function isOver() : bool
    {
        return count($this->keysDown) + count($this->keysReleased) == 0;
    }

    public function noteOn(string $key, int $velocity = self::VELOCITY_MAX) : void
    {
        if (!isset($this->keys[$key])) {
            throw new \InvalidArgumentException(sprintf('Unknown note "%s"', $key));
        }

        if (isset($this->sustainedKeys[$key])) {
            $this->sustainedKeys[$key]->noteOff();
            $this->keysReleased[] = $this->sustainedKeys[$key];
            unset($this->sustainedKeys[$key]);
        }

        if (isset($this->keysDown[$key])) {
            $this->noteOff($key);
        }

        $this->keysDown[$key] = $this->buildEffects($this->keys[$key], $this->clock);
        $this->keysDown[$key]->noteOn($velocity / self::VELOCITY_MAX);
    }

    public function noteOff(string $key) : void
    {
        if (!isset($this->keysDown[$key])) {
            return;
        }

        $generator = $this->keysDown[$key];
        unset($this->keysDown[$key]);

        if ($this->isSustainOn) {
            $this->sustainedKeys[$key] = $generator;

            return;
        }

        $this->keysReleased[] = $generator;
        $generator->noteOff();
    }

    public function sustainOn(): void
    {
        $this->isSustainOn = true;
    }

    public function sustainOff(): void
    {
        $this->isSustainOn = false;
    }

    public function noteOffAll() : void
    {
        foreach ($this->keysDown as $key => $none) {
            $this->noteOff($key);
        }
    }

    private function initializeKeys() : void
    {
        foreach (NotesFrequencies::FREQUENCIES as $key => $frequency) {
            $this->keys[$key] = $this->initializeKey($frequency, $this->clock);
        }
    }

    protected function buildEffects(Generator $generator, Clock $clock) : Effect
    {
        return new VoidEffect($generator);
    }

    protected abstract function initializeKey(float $frequency, Clock $clock) : Generator;
}
