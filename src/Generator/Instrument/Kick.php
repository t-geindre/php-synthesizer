<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Envelope;
use Synthesizer\Generator\Oscillator\Shape;
use Synthesizer\Reference\Frequencies;
use Synthesizer\Shape\Constant;
use Synthesizer\Shape\Linear;
use Synthesizer\Shape\Square;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock\Clock;

class Kick extends Instrument
{
    protected function getOscillator(float $frequency): Oscillator
    {
        $frequency = Frequencies::FREQUENCIES['F1'];

        $stack = new Stack();
        $lfo = new Shape(.15, new Square(0, 200));

        $osc = new Base($frequency, .99, 0, Base::SHAPE_SINUSOIDAL);
        $osc->setLfo($lfo);
        $stack->push($osc);

        $osc = new Base($frequency, .1, 0, Base::SHAPE_TRIANGLE);
        $osc->setLfo($lfo);
        $stack->push($osc);

        return $stack;
    }

    protected function getEnvelope(Oscillator $generator, Clock $clock): Envelope
    {
        return new Envelope(
            $generator,
            $clock,
//            new Constant(1, 1000),
//            new Constant(1, 100),
            new Linear(1, 2),
            new Square(0, 450),
            new Constant(0),
            new Square(0, 450),
        );
    }
}
