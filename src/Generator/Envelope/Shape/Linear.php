<?php

namespace Synthesizer\Generator\Envelope\Shape;

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

    public function getAmplitude(float $deltaTime): float
    {
        return $this->from + ($deltaTime / $this->duration * ($this->to - $this->from));
    }

    public function getTargetAmplitude(): float
    {
        return $this->to;
    }

    public function setAmplitudeFrom(float $amplitude): void
    {
        $this->from = $amplitude;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
