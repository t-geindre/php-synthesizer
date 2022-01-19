<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Generator\Instrument\Utils\Envelope;

class Retro extends Instrument
{
    protected function initializeKey(float $frequency): Generator
    {
        $ref = new Oscillator($frequency, 0.4, $this->clock, Oscillator::SHAPE_TRIANGLE);
        $ref->setLfo(new Oscillator(5, 0.4, $this->clock, Oscillator::SHAPE_SINUSOIDAL));

        $stack = new Stack();
        $stack->push($ref);
        $stack->push(new Oscillator($frequency * 2 , 0.25, $this->clock, Oscillator::SHAPE_TRIANGLE));
        $stack->push(new Oscillator($frequency * 4 , 0.25, $this->clock, Oscillator::SHAPE_TRIANGLE));
        $stack->push(new Oscillator($frequency * 6 , 0.25, $this->clock, Oscillator::SHAPE_TRIANGLE));

        return $stack;
    }

    protected function getEnvelope(Generator $generator): Envelope
    {
        $env = new Envelope($generator, $this->clock);
        $env->setAttackTime(.05);
        $env->setDecayTime(.5);
        $env->setSustainAmplitude(.6);
        $env->setReleaseTime(.2);

        return $env;
    }
}
