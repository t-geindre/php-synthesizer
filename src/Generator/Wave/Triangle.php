<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class Triangle implements Generator
{

    private Generator $generator;

    public function __construct(float $frequency, Clock $clock)
    {
        $this->generator = new Sinusoidal($frequency, $clock);
    }

    public function start(): void
    {
        $this->generator->start();
    }

    public function stop(): void
    {
        $this->generator->stop();
    }

    public function isOver(): bool
    {
        return $this->generator->isOver();
    }

    public function getValue(): float
    {
        return asin($this->generator->getValue());
    }
}
