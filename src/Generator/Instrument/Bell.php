<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Filter\FirLowPass;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock\Clock;

class Bell extends Instrument
{
    protected function getOscillator(float $frequency): Oscillator
    {
        $stack = new Stack();

        $osc = new Base($frequency, 0.8, 0, Base::SHAPE_SINUSOIDAL);

        $stack->push($osc);
        $stack->push(new Base($frequency * 4, 0.2, 0, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency * 8, 0.16, 0, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency * 16, 0.16, 0, Base::SHAPE_TRIANGLE));

        return new FirLowPass($stack, .3);
    }

    protected function getEnvelope(Oscillator $generator, Clock $clock): Envelope
    {
        return Envelope::linear($generator, $clock, 5, 2000, 0, 500);
    }
}
