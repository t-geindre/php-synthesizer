<?php

namespace Synthesizer\Generator\Oscillator\Filter;

use Synthesizer\Generator\LfoAware;
use Synthesizer\Generator\Oscillator\Oscillator;

class FirLowPass implements Oscillator, LfoAware
{
    private Oscillator $oscillator;
    private float $lastValue = 0;
    private ?Oscillator $lfo = null;
    private float $cuteOff;

    public function __construct(Oscillator $generator, float $cuteOff = .1)
    {
        $this->oscillator = $generator;
        $this->cuteOff = $cuteOff;
    }

    public function getValue(float $deltaTime): float
    {
        $cutOff = $this->lfo != null ? ($this->lfo->getValue($deltaTime) + 1) / 2 : $this->cuteOff;
        return $this->lastValue = (1 - $cutOff) * $this->lastValue + $cutOff * $this->oscillator->getValue($deltaTime);
    }

    public function setLfo(?Oscillator $lfo): void
    {
        $this->lfo = $lfo;
    }
}
