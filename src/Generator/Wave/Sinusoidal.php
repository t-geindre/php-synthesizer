<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Generator\Generator;

class Sinusoidal implements Generator
{
    private float $wave;
    private int $sample = 1;
    private bool $isStopped = false;

    public function __construct(float $frequency, int $sampleRate)
    {
        $this->wave = 2 * pi() * $frequency / $sampleRate;
    }

    public function getValue() : float
    {
        return sin($this->sample++ * $this->wave);
    }

    public function start(): void
    {
        $this->isStopped = false;
    }

    public function stop(): void
    {
        $this->isStopped = true;
    }

    public function isOver(): bool
    {
        return $this->isStopped;
    }
}
