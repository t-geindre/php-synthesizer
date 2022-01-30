<?php

namespace Synthesizer\Generator\Oscillator\Filter;

use Synthesizer\Generator\Oscillator\Oscillator;

class FirLowPass implements Oscillator
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
        return $this->lastValue =
            (1 - $this->cutOff) *
            $this->lastValue + $this->cutOff *
            $this->oscillator->getValue($deltaTime)
        ;
    }

    public function setCutOff(float $cutOff): void
    {
        $this->cutOff = $cutOff;
    }
}
