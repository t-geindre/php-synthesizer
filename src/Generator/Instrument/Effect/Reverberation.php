<?php

namespace Synthesizer\Generator\Instrument\Effect;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class Reverberation implements Effect
{
    private Generator $generator;
    /** @var Delay[]  */
    private array $delayed;

    public function __construct(Generator $generator, Clock $clock)
    {
        $this->generator = $generator;
        $this->delayed[] = new Delay($generator, $clock, .4);
    }

    public function noteOn(float $velocity): void
    {
        foreach ($this->delayed as $delayed) {
            $delayed->noteOn($velocity);
        }
    }

    public function noteOff(): void
    {
        foreach ($this->delayed as $delayed) {
            $delayed->noteOff();
        }
    }

    public function isOver(): bool
    {
        foreach ($this->delayed as $delayed) {
            if (!$delayed->isOver()) {
                return false;
            }
        }

        return true;
    }

    public function getValue(): float
    {
        $value = $this->generator->getValue();
        $amplitude = 1/4;

        foreach ($this->delayed as $delayed) {
            $value += $delayed->getValue() * $amplitude;
            $amplitude /= 2;
        }

        return $value;
    }
}
