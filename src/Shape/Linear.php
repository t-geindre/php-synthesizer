<?php

namespace Synthesizer\Shape;

class Linear implements Shape
{
    private float $to;
    private int $duration;
    private float $from = 0;

    public function __construct(float $to, int $duration)
    {
        $this->to = $to;
        $this->duration = $duration;
    }

    public function getValue(float $deltaTime): float
    {
        return $this->from + ($deltaTime / $this->duration * ($this->to - $this->from));
    }

    public function getTargetValue(): float
    {
        return $this->to;
    }

    public function setValueFrom(float $value): void
    {
        $this->from = $value;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
