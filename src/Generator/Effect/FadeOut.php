<?php

namespace Synthesizer\Generator\Effect;

use Synthesizer\Generator\Generator;

class FadeOut implements Effect
{
    private Generator $generator;
    private int $sampleRate;
    private float $decVelocity = 100;
    private bool $isRunning = false;
    private float $amplitude = 1;

    public function __construct(Generator $generator, int $sampleRate)
    {
        $this->generator = $generator;
        $this->sampleRate = $sampleRate;
    }

    public function configure(array $config): void
    {
    }

    public function start(): void
    {
        $this->isRunning = false;
        $this->amplitude = 1;

        $this->generator->start();
    }

    public function stop(): void
    {
        $this->generator->stop();

        $this->isRunning = true;
    }

    public function isOver(): bool
    {
        return $this->generator->isOver() && $this->amplitude <= 0;
    }

    public function getValue(): float
    {
        if ($this->isRunning) {
            $this->amplitude -= $this->decVelocity / $this->sampleRate;
            $this->amplitude = max(0, $this->amplitude);
        }

        return $this->generator->getValue() * $this->amplitude;
    }
}
