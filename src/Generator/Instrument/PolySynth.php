<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Effect\Delay;
use Synthesizer\Generator\Effect\Effect;
use Synthesizer\Generator\Envelope\Envelope;
use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock\Clock;

class PolySynth extends Instrument
{
    protected function initializeKey(float $frequency, Clock $clock): Oscillator
    {
        $stack = new Stack();

        $stack->push(new Base($frequency, 0.3, 0, $clock, Base::SHAPE_SAWTOOTH));
        $stack->push(new Base($frequency - 3, 0.3, 1, $clock, Base::SHAPE_SAWTOOTH));
        $stack->push(new Base($frequency + 3, 0.3, 1, $clock, Base::SHAPE_SAWTOOTH));

        return $stack;
    }

    protected function getEnvelope(Generator $generator, Clock $clock): Envelope
    {
        return Envelope::linear($generator, $clock, 2, 2000, 0, 200);
    }

    protected function addEffects(Generator $generator, Clock $clock): Effect
    {
        return new Delay($generator, $clock, 300, .3);
    }
}
