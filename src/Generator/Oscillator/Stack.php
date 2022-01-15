<?php

namespace Synthesizer\Generator\Oscillator;

use Synthesizer\Generator\Generator;

class Stack implements Generator
{
    /** @var array<Generator> */
    private array $stack;

    public function push(Generator $generator)
    {
        $this->stack[] = $generator;
    }

    public function isOver(): bool
    {
        foreach ($this->stack as $generator) {
            if(!$generator->isOver()) {
                return false;
            }
        }

        return true;
    }

    public function getValue(): float
    {
        return array_sum(array_map(
            fn (Generator $generator) => $generator->getValue(),
            $this->stack
        ));
    }
}
