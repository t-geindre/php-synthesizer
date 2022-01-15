<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Oscillator\Sinusoidal;
use Synthesizer\Generator\Oscillator\Square;
use Synthesizer\Generator\Oscillator\Triangle;
use Synthesizer\Generator\Oscillator\Stack;

class Retro extends Instrument
{
    protected function initializeKey(float $frequency): Generator
    {
        $stack = new Stack();
        $stack->push(new Sinusoidal($frequency * 0.5, $this->clock));
        $stack->push(new Sinusoidal($frequency * 5, $this->clock), 0.6);
        $stack->push(new Square($frequency , $this->clock), 0.5);
        $stack->push(new Square($frequency * 4, $this->clock), 0.2);
        $stack->push(new Square($frequency * 8, $this->clock), 0.1);
        $stack->push(new Triangle($frequency * 2 , $this->clock), 0.3);

        return $stack;
    }
}
