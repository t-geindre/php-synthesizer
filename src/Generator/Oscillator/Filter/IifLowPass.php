<?php

namespace Synthesizer\Generator\Oscillator\Filter;

use Synthesizer\Generator\Oscillator\Oscillator;

class IifLowPass implements Oscillator
{
    private Oscillator $oscillator;
    private float $lastValue = 0;
    private float $cutOff;

    public function __construct(Oscillator $generator, float $cutOff = .1)
    {
        $this->oscillator = $generator;
        $this->cutOff = $cutOff;
    }

    public function getValue(float $deltaTime): float
    {
        // y[i] := y[i-1] + α * (x[i] - y[i-1])
        return $this->lastValue =
            $this->lastValue +
            $this->cutOff * ($this->oscillator->getValue($deltaTime) - $this->lastValue)
        ;
    }

    public function setCutOff(float $cutOff): void
    {
        $this->cutOff = $cutOff;
    }
}
