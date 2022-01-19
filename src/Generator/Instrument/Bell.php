<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Utils\Envelope;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;

class Bell extends Instrument
{
    protected function initializeKey(float $frequency): Generator
    {
        $ref = new Oscillator($frequency * 2, 0.7, $this->clock, Oscillator::SHAPE_SINUSOIDAL);
        $ref->setLfo(new Oscillator(5, 0.3, $this->clock, Oscillator::SHAPE_SINUSOIDAL));

        $stack = new Stack();
        $stack->push($ref);
        $stack->push(new Oscillator($frequency * 4, 0.1, $this->clock, Oscillator::SHAPE_TRIANGLE));
        $stack->push(new Oscillator($frequency * 8, 0.1, $this->clock, Oscillator::SHAPE_TRIANGLE));
        $stack->push(new Oscillator($frequency * 16, 0.1, $this->clock, Oscillator::SHAPE_TRIANGLE));

        return $stack;
    }

    protected function getEnvelope(Generator $generator): Envelope
    {
        $env = new Envelope($generator, $this->clock);
        $env->setAttackTime(.005);
        $env->setDecayTime(.8);
        $env->setSustainAmplitude(.1);
        $env->setReleaseTime(.5);

        return $env;
    }
}
