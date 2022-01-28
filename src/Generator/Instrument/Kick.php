<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Envelope\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock\Clock;

class Kick extends Instrument
{
    protected function getOscillator(float $frequency): Oscillator
    {
        $stack = new Stack();
        $stack->push(new Base($frequency, 2, 0, Base::SHAPE_SINUSOIDAL));
        $stack->push(new Base($frequency, .01, 0, Base::SHAPE_NOISE));

        return $stack;
    }

    protected function getEnvelope(Oscillator $generator, Clock $clock): Envelope
    {
        return Envelope::linear($generator, $clock, 10, 50, 0, 100);
    }
}
