<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock\Clock;

class MonoBass extends Instrument
{
    protected function getOscillator(float $frequency): Oscillator
    {
        $stack = new Stack();
        $stack->push(new Base($frequency, 1, 0, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency / 2, .4, 1, Base::SHAPE_SAWTOOTH));

        return $stack;
    }

    protected function getEnvelope(Oscillator $generator, Clock $clock): Envelope
    {
        return Envelope::linear($generator, $clock, 20, 700, 0, 100);
    }
}
