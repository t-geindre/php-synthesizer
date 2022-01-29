<?php

namespace Synthesizer\Generator\Envelope\Shape;

class Square implements Shape
{
    private float $from = 0;
    private float $to;
    private int $duration;

    public function __construct(float $to, int $duration)
    {
        $this->to = $to;
        $this->duration = $duration;
    }

    public function getAmplitude(float $deltaTime): float
    {
        $a =
            ($deltaTime - $this->duration) ** 2 *
            (($this->from - $this->to) / $this->duration ** 2)
            + $this->to
        ;

        return $a;
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
