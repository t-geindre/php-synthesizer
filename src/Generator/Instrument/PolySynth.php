<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Effect\Delay;
use Synthesizer\Generator\Instrument\Effect\Effect;
use Synthesizer\Generator\Instrument\Effect\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock;

class PolySynth extends Instrument
{
    protected function initializeKey(float $frequency, Clock $clock): Generator
    {
        $stack = new Stack();

        $stack->push(new Base($frequency, 0.3, 0, $clock, Base::SHAPE_SAWTOOTH));
        $stack->push(new Base($frequency - 3, 0.3, 1, $clock, Base::SHAPE_SAWTOOTH));
        $stack->push(new Base($frequency + 3, 0.3, 1, $clock, Base::SHAPE_SAWTOOTH));

        return $stack;
    }

    protected function buildEffects(Generator $generator, Clock $clock): Effect
    {
        $eff = new Envelope($generator, $clock);
        $eff->setAttackTime(.002);
        $eff->setDecayTime(2);
        $eff->setSustainAmplitude(0);
        $eff->setReleaseTime(.2);

        return new Delay($eff, $clock, .4, .2);
    }
}
