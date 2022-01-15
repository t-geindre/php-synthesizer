<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Generator\Generator;

class Square implements Generator
{

    private Generator $generator;

    public function __construct(float $frequency, int $sampleRate)
    {
        $this->generator = new Sinusoidal($frequency, $sampleRate);
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
        return $this->generator->getValue() > 0 ? 1 : 0;
    }
}
