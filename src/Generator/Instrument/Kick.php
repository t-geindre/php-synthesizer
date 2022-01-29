<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Envelope\Envelope;
use Synthesizer\Generator\Envelope\Shape\Constant;
use Synthesizer\Generator\Envelope\Shape\Square;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock\Clock;

class Kick extends Instrument
{
    protected function getOscillator(float $frequency): Oscillator
    {
        $stack = new Stack();
        $lfo = new Base(1, 100, 250, BAse::SHAPE_TRIANGLE);

        $osc = new Base($frequency, .97, 0, Base::SHAPE_SINUSOIDAL);
        $osc->setLfo($lfo);
        $stack->push($osc);

        $osc = new Base($frequency, .3, 0, Base::SHAPE_TRIANGLE);
        $osc->setLfo($lfo);
        $stack->push($osc);

        return $stack;
    }

    protected function getEnvelope(Oscillator $generator, Clock $clock): Envelope
    {
        return new Envelope(
            $generator,
            $clock,
            new Constant(1),
            new Square(0, 400),
            new Constant(0),
            new Constant(0)
        );
    }
}
