<?php

namespace Synthesizer\Generator\Envelope\Map;

interface Map
{
    public function setStepByMs(int $steps): void;
    public function getAmplitude(float $amplitude, float $deltaTime): float;
    public function getDuration(): int;
}
