<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Effect\Envelope;
use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Wave\DigitalSaw;
use Synthesizer\Generator\Wave\Sinusoidal;
use Synthesizer\Generator\Wave\Triangle;
use Synthesizer\Generator\Wave\WaveStack;

class RetroKeyboard extends Keyboard
{
    protected function initializeKey(float $frequency): Generator
    {
        $stack = new WaveStack($frequency, $this->clock);
        $stack->push(new Sinusoidal($frequency * 0.5, $this->clock));
        $stack->push(new DigitalSaw($frequency , $this->clock), 0.5);
        $stack->push(new DigitalSaw($frequency * 4, $this->clock), 0.2);
        $stack->push(new DigitalSaw($frequency * 8, $this->clock), 0.1);
        $stack->push(new Triangle($frequency * 2 , $this->clock), 0.3);
        return $stack;
    }

    protected function initializeNote(Generator $generator): Generator
    {
        return new Envelope($generator, $this->clock);
    }
}
