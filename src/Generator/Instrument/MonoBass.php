<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;

class MonoBass extends Instrument
{
    protected function getOscillator(float $frequency): Oscillator
    {
        $stack = new Stack();
        $stack->push(new Base($frequency, 1, 0, Base::SHAPE_TRIANGLE));

        return $stack;
    }

    protected function getEnvelope(Oscillator $generator): Envelope
    {
        return Envelope::linear($generator, 20, 700, 0, 100);
    }
}
