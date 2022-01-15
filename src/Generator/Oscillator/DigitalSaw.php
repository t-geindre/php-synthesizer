<?php

namespace Synthesizer\Generator\Oscillator;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class DigitalSaw implements Generator
{
    private float $frequency;
    private Clock $clock;

    public function __construct(float $frequency, Clock $clock)
    {
        $this->frequency = $frequency;
        $this->clock = $clock;
    }

    public function getValue() : float
    {
        return (2.0 / pi()) * ($this->frequency * pi() * fmod($this->clock->getTime(), 1.0 / $this->frequency) - (pi() / 2.0));
    }

    public function isOver(): bool
    {
        return true;
    }
}
