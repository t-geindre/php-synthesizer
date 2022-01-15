<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class AnalogSaw implements Generator
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
        $value = 0;

		for ($i = 1; $i < 20; $i++) {
			$value += (sin($i * $this->angularVelocity * $this->clock->getTime())) / $i;
        }

		return $value * (2.0 / pi());
    }

    public function isOver(): bool
    {
        return true;
    }
}
