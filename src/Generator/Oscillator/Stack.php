<?php

namespace Synthesizer\Generator\Oscillator;

use Synthesizer\Generator\Stack as GeneratorStack;

class Stack implements Oscillator
{
    private GeneratorStack $stack;
    private float $lastValue = 0;

    public function __construct(int $mode = GeneratorStack::MODE_ADDITIVE)
    {
        $this->stack = new GeneratorStack($mode);
    }

    public function push(Oscillator $oscillator) : void
    {
        $this->stack->push($oscillator);
    }

    public function isOver(): bool
    {
        return $this->lastValue < 0.0001 && $this->lastValue > -0.9999;
    }

    public function getValue(): float
    {
        return $this->lastValue = $this->stack->getValue();
    }
}
