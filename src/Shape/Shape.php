<?php

namespace Synthesizer\Shape;

interface Shape
{
    public function setValueFrom(float $value): void;
    public function getValue(float $deltaTime): float;
    public function getTargetValue(): float;
    public function getDuration(): int;
}
