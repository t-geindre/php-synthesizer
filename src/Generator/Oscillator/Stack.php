<?php

namespace Synthesizer\Generator\Oscillator;

use Synthesizer\Generator\Generator;

class Stack implements Generator
{
    /** @var array<array<Generator, float>> */
    private array $stack;

    public function push(Generator $wave, float $amplitude = 1)
    {
        $this->stack[] = [$wave, $amplitude];
    }

    public function isOver(): bool
    {
        foreach ($this->stack as [$wave,]) {
            if(!$wave->isOver()) {
                return false;
            }
        }

        return true;
    }

    public function getValue(): float
    {
        return array_sum(array_map(
            fn (array $wave) => $wave[0]->getValue() * $wave[1],
            $this->stack
        ));
    }
}
