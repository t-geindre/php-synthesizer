<?php
namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Effect\Effect;
use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Utils\NotesFrequencies;
use Synthesizer\Generator\Wave\Sinusoidal;
use Synthesizer\Time\Clock;

abstract class Keyboard
{
    /** @var array<Sinusoidal>  */
    private array $keys;
    /** @var array<Effect> */
    private array $keysDown = [];
    /** @var array<string, array> */
    protected Clock $clock;

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

        return $value;
    }

    public function isOver() : bool
    {
        return count($this->keysDown) == 0;
    }

    public function keyDown(string $key) : void
    {
        if (!isset($this->keysDown[$key])) {
            $this->keysDown[$key] = $this->initializeNote($this->keys[$key]);
        }
        $this->keysDown[$key]->start();
    }

    public function keyUp(string $key) : void
    {
        $this->keysDown[$key]->stop();
    }

    public function keyUpAll() : void
    {
        foreach ($this->keysDown as $key => $none) {
            $this->keyUp($key);
        }
    }

    private function initializeKeys() {
        foreach (NotesFrequencies::FREQUENCIES as $key => $frequency) {
            $this->keys[$key] = $this->initializeKey($frequency);
        }
    }

    protected abstract function initializeKey(float $frequency) : Generator;
    protected abstract function initializeNote(Generator $generator) : Generator;
}