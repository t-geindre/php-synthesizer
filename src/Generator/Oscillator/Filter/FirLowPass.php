<?php

namespace Synthesizer\Generator\Oscillator\Filter;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\LfoAware;

class FirLowPass implements Generator, LfoAware
{
    private Generator $generator;
    private float $lastValue = 0;
    private ?Generator $lfo = null;
    private float $cuteOff;

    public function __construct(Generator $generator, float $cuteOff = .1)
    {
        $this->generator = $generator;
        $this->cuteOff = $cuteOff;
    }

    public function isOver(): bool
    {
        return $this->generator->isOver();
    }

    public function getValue(): float
    {
        $cutOff = $this->lfo != null ? ($this->lfo->getValue() + 1) / 2 : $this->cuteOff;
        return $this->lastValue = (1 - $cutOff) * $this->lastValue + $cutOff * $this->generator->getValue();
    }

    public function setLfo(?Generator $lfo)
    {
        $this->lfo = $lfo;
    }
}
