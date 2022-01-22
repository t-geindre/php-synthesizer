<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Effect\Effect;
use Synthesizer\Generator\Instrument\Effect\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock;

class Organ extends Instrument
{
    protected function initializeKey(float $frequency, Clock $clock): Generator
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

    protected function buildEffects(Generator $generator, Clock $clock): Effect
    {
        $env = new Envelope($generator, $clock);
        $env->setAttackTime(.05);
        $env->setDecayTime(.5);
        $env->setSustainAmplitude(.6);
        $env->setReleaseTime(.2);

        return $env;
    }
}
