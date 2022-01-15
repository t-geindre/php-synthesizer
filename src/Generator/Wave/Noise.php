<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Time\Clock;

class Noise implements Wave
{

    public function start(): void
    {
    }

    public function stop(): void
    {
    }

    public function isOver(): bool
    {
        return true;
    }

    public function getValue(): float
    {
        return mt_rand(0, 1000) / 1000;
    }

    public function __construct(float $frequency, Clock $clock)
    {
    }
}
