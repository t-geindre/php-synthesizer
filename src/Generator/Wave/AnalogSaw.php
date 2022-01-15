<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Time\Clock;

class AnalogSaw implements Wave
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
        $value = 0;

		for ($i = 1; $i < 20; $i++) {
			$value += (sin($i * $this->angularVelocity * $this->clock->getTime())) / $i;
        }

		return $value * (2.0 / pi());
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
