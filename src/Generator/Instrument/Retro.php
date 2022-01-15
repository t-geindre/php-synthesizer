<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Wave\Sinusoidal;
use Synthesizer\Generator\Wave\Square;
use Synthesizer\Generator\Wave\Triangle;
use Synthesizer\Generator\Wave\WaveStack;

class Retro extends Instrument
{
    protected function initializeKey(float $frequency): Generator
    {
        $stack = new WaveStack();
        $stack->push(new Sinusoidal($frequency * 0.5, $this->clock));
        $stack->push(new Sinusoidal($frequency * 5, $this->clock), 0.6);
        $stack->push(new Square($frequency , $this->clock), 0.5);
        $stack->push(new Square($frequency * 4, $this->clock), 0.2);
        $stack->push(new Square($frequency * 8, $this->clock), 0.1);
        $stack->push(new Triangle($frequency * 2 , $this->clock), 0.3);

        return $stack;
    }
}
