<?php

namespace Synthesizer\Generator\Envelope\Shape;

class Constant implements Shape
{
    private float $const;
    private int $duration;

    public function __construct(float $const, int $duration = 0)
    {
        $this->const = $const;
        $this->duration = $duration;
    }

    public function getAmplitude(float $deltaTime): float
    {
        return $this->const;
    }

    public function getTargetAmplitude(): float
    {
        return $this->const;
    }

    public function setAmplitudeFrom(float $amplitude): void
    {
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
