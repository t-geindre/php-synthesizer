<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock\Clock;

class Organ extends Instrument
{
    protected function getOscillator(float $frequency): Oscillator
    {
        $ref = new Base($frequency, 0.8, 0, Base::SHAPE_TRIANGLE);

        $stack = new Stack();
        $stack->push($ref);
        $stack->push(new Base($frequency * 2 , 0.5, 0, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency * 4 , 0.5, 0, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency * 6 , 0.5, 0, Base::SHAPE_TRIANGLE));

        return $stack;
    }

    protected function getEnvelope(Oscillator $generator, Clock $clock): Envelope
    {
        return Envelope::linear($generator, $clock, 50, 500, .6, 200);
    }
}
