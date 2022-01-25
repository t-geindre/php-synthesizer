<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Envelope\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock;

class Organ extends Instrument
{
    protected function initializeKey(float $frequency, Clock $clock): Oscillator
    {
        $ref = new Base($frequency, 0.8, 0, $clock, Base::SHAPE_TRIANGLE);
        $ref->setLfo(new Base(5, 0.4, 0, $clock, Base::SHAPE_SINUSOIDAL));

        $stack = new Stack();
        $stack->push($ref);
        $stack->push(new Base($frequency * 2 , 0.5, 0, $clock, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency * 4 , 0.5, 0, $clock, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency * 6 , 0.5, 0, $clock, Base::SHAPE_TRIANGLE));

        return $stack;
    }

    protected function getEnvelope(Generator $generator, Clock $clock): Envelope
    {
        $env = new Envelope($generator, $clock);
        $env->setAttackTime(.05);
        $env->setDecayTime(.5);
        $env->setSustainAmplitude(.6);
        $env->setReleaseTime(.2);

        return $env;
    }
}
