<?php

namespace Synthesizer\Generator\Oscillator;

use Synthesizer\Generator\Generator;

class Noise implements Generator
{
    public function isOver(): bool
    {
        return true;
    }

    public function getValue(): float
    {
        return mt_rand(0, 1000) / 1000;
    }
}
