<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Effect\Effect;
use Synthesizer\Generator\Instrument\Effect\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock;

class Kick extends Instrument
{
    protected function initializeKey(float $frequency, Clock $clock): Generator
    {
        $stack = new Stack();
        $stack->push(new Base($frequency, 2, 0, $clock, Base::SHAPE_SINUSOIDAL));
        $stack->push(new Base($frequency, .01, 0, $clock, Base::SHAPE_NOISE));

        return $stack;
    }

    protected function buildEffects(Generator $generator, Clock $clock): Effect
    {
        $eff = new Envelope($generator, $clock);
        $eff->setAttackTime(.01);
        $eff->setDecayTime(.05);
        $eff->setSustainAmplitude(0);
        $eff->setReleaseTime(.1);

        return $eff;
    }
}
