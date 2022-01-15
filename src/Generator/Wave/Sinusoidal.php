<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Time\Clock;

class Sinusoidal implements Wave
{
    private float $angularVelocity;
    private bool $isStopped = false;
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
