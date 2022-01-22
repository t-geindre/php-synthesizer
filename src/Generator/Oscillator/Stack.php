<?php

namespace Synthesizer\Generator\Oscillator;

class Stack implements Oscillator
{
    /** @var Oscillator[] */
    private array $stack;
    private float $lastValue = 0;
    private int $mode;

    const MODE_ADDITIVE = 1;
    const MODE_SUBTRACTIVE = -1;

    public function __construct(int $mode = self::MODE_ADDITIVE)
    {
        $this->mode = $mode;
    }

    public function push(Oscillator $oscillator) : void
    {
        $this->stack[] = $oscillator;
    }

    public function isOver(): bool
    {
        return $this->lastValue < 0.0001 && $this->lastValue > -0.9999;
    }

    public function getValue(): float
    {
        $this->lastValue = array_reduce(
            $this->stack,
            fn (float $carry, Oscillator $oscillator) => $carry + $oscillator->getValue() * $this->mode,
            0.0
        );

        return $this->lastValue;
    }
}
