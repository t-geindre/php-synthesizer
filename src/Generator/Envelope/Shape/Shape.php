<?php

namespace Synthesizer\Generator\Envelope\Shape;

interface Shape
{
    public function setAmplitudeFrom(float $amplitude): void;
    public function getAmplitude(float $deltaTime): float;
    public function getTargetAmplitude(): float;
    public function getDuration(): int;
}
