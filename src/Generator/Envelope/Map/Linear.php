<?php

namespace Synthesizer\Generator\Envelope\Map;

class Linear implements Map
{
    private float $to;
    private int $duration;
    private int $stepsByMs;

    public function __construct(float $to, int $duration)
    {
        $this->to = $to;
        $this->duration = $duration;
    }

    public function setStepByMs(int $steps): void
    {
        $this->stepsByMs = $steps;
    }

    public function getAmplitude(float $amplitude, float $deltaTime): float
    {
        $timeLeft = $this->duration - $deltaTime;

        if ($timeLeft <= 0) {
            return $this->to;
        }

        return max(0, $amplitude + ($this->to - $amplitude) / $timeLeft / $this->stepsByMs);
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
