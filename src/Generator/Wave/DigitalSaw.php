<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Time\Clock;

class DigitalSaw implements Wave
{
    private float $frequency;
    private bool $isStopped = false;
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
