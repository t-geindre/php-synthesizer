<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class Square implements Generator
{
    private Generator $generator;

    public function __construct(float $frequency, Clock $clock)
    {
        $this->generator = new Sinusoidal($frequency, $clock);
    }

    public function isOver(): bool
    {
        return $this->generator->isOver();
    }

    public function getValue(): float
    {
        return $this->generator->getValue() > 0 ? 1 : -1;
    }
}
