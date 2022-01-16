<?php

namespace Synthesizer\Generator\Oscillator;

use Synthesizer\Generator\Generator;

class Stack implements Generator
{
    /** @var array<Generator> */
    private array $stack;
    private float $lastValue = 0;

    public function push(Generator $generator)
    {
        $this->stack[] = $generator;
    }

    public function isOver(): bool
    {
        return $this->lastValue < 0.0001 && $this->lastValue > -0.9999;
    }

    public function getValue(): float
    {
        $this->lastValue = array_sum(array_map(
            fn (Generator $generator) => $generator->getValue(),
            $this->stack
        ));

        return $this->lastValue;
    }
}
