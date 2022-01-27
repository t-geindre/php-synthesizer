<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Envelope\Envelope;
use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock\Clock;

class MonoBass extends Instrument
{
    protected function initializeKey(float $frequency, Clock $clock): Oscillator
    {
        $stack = new Stack();
        $stack->push(new Base($frequency, 1, 0, $clock, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency / 2, .4, 1, $clock, Base::SHAPE_TRIANGLE));

        return $stack;
    }

    protected function getEnvelope(Generator $generator, Clock $clock): Envelope
    {
        $env = new Envelope($generator, $clock);
        $env->setAttackTime(20);
        $env->setDecayTime(700);
        $env->setSustainAmplitude(0);
        $env->setReleaseTime(100);

        return $env;
    }
}
