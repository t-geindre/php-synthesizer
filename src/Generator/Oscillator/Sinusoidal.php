<?php

namespace Synthesizer\Generator\Oscillator;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class Sinusoidal implements Generator
{
    private float $angularVelocity;
    private Clock $clock;

    public function __construct(float $frequency, Clock $clock)
    {
        $this->angularVelocity = 2 * pi() * $frequency;
        $this->clock = $clock;
    }

    public function getValue() : float
    {
        return sin($this->angularVelocity * $this->clock->getTime());
    }

    public function isOver(): bool
    {
        return true;
    }
}
