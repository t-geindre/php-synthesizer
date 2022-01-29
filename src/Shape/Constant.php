<?php

namespace Synthesizer\Shape;

class Constant implements Shape
{
    private float $const;
    private int $duration;

    public function __construct(float $const, int $duration = 0)
    {
        $this->const = $const;
        $this->duration = $duration;
    }

    public function getValue(float $deltaTime): float
    {
        return $this->const;
    }

    public function getTargetValue(): float
    {
        return $this->const;
    }

    public function setValueFrom(float $value): void
    {
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
