<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Envelope\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock;

class Kick extends Instrument
{
    protected function initializeKey(float $frequency, Clock $clock): Oscillator
    {
        $stack = new Stack();
        $stack->push(new Base($frequency, 2, 0, $clock, Base::SHAPE_SINUSOIDAL));
        $stack->push(new Base($frequency, .01, 0, $clock, Base::SHAPE_NOISE));

        return $stack;
    }

    protected function getEnvelope(Generator $generator, Clock $clock): Envelope
    {
        $env = new Envelope($generator, $clock);
        $env->setAttackTime(.01);
        $env->setDecayTime(.05);
        $env->setSustainAmplitude(0);
        $env->setReleaseTime(.1);

        return $env;
    }
}
