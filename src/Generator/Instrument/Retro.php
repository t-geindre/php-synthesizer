<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;

class Retro extends Instrument
{
    protected function initializeKey(float $frequency): Generator
    {
        $stack = new Stack();
        $stack->push(new Oscillator($frequency * 0.5, 1, $this->clock, Oscillator::SHAPE_SINUSOIDAL));
        $stack->push(new Oscillator($frequency * 3, 0.6, $this->clock, Oscillator::SHAPE_SINUSOIDAL));
        $stack->push(new Oscillator($frequency, 0.5, $this->clock, Oscillator::SHAPE_SQUARE));
        $stack->push(new Oscillator($frequency * 4, 0.2, $this->clock, Oscillator::SHAPE_SQUARE));
        $stack->push(new Oscillator($frequency * 8, 0.1, $this->clock, Oscillator::SHAPE_SQUARE));
        $stack->push(new Oscillator($frequency * 2 , 0.5, $this->clock, Oscillator::SHAPE_TRIANGLE));

        return $stack;
    }
}
