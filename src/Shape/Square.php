<?php

namespace Synthesizer\Shape;

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

    public function getValue(float $deltaTime): float
    {
        $a =
            ($deltaTime - $this->duration) ** 2 *
            (($this->from - $this->to) / $this->duration ** 2)
            + $this->to
        ;

        return $a;
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
