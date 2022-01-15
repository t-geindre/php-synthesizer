<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Time\Clock;

class WaveStack implements Wave
{
    /** @var array<array<Wave, float>> */
    private array $stack;

    public function __construct(float $frequency, Clock $clock)
    {
    }

    public function push(Wave $wave, float $amplitude = 1)
    {
        $this->stack[] = [$wave, $amplitude];
    }

    public function start(): void
    {
        foreach ($this->stack as [$wave,]) {
            $wave->start();
        }
    }

    public function stop(): void
    {
        foreach ($this->stack as [$wave,]) {
            $wave->stop();
        }
    }

    public function isOver(): bool
    {
        foreach ($this->stack as [$wave,]) {
            if(!$wave->isOver()) {
                return false;
            }
        }

        return true;
    }

    public function getValue(): float
    {
        return array_sum(array_map(
            fn (array $wave) => $wave[0]->getValue() * $wave[1],
            $this->stack
        ));
    }
}
