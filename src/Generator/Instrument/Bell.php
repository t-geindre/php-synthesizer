<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Envelope\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Filter\FirLowPass;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock;

class Bell extends Instrument
{
    protected function initializeKey(float $frequency, Clock $clock): Oscillator
    {
        $stack = new Stack();

        $osc = new Base($frequency, 0.8, 0, $clock, Base::SHAPE_SINUSOIDAL);
        $osc->setLfo(new Base(5, 0.3, 0, $clock, Base::SHAPE_SINUSOIDAL));

        $stack->push($osc);
        $stack->push(new Base($frequency * 4, 0.2, 0, $clock, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency * 8, 0.16, 0, $clock, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency * 16, 0.16, 0, $clock, Base::SHAPE_TRIANGLE));

        return new FirLowPass($stack, .3);
    }

    protected function getEnvelope(Generator $generator, Clock $clock): Envelope
    {
        $env = new Envelope($generator, $clock);
        $env->setAttackTime(.005);
        $env->setDecayTime(2);
        $env->setSustainAmplitude(0);
        $env->setReleaseTime(.5);

        return $env;
    }
}
