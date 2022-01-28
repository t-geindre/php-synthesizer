<?php

namespace Synthesizer\Generator\Oscillator;

interface Oscillator
{
    public function getValue(float $deltaTime): float;
}
