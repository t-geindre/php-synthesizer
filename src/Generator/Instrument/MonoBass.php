<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Effect\Effect;
use Synthesizer\Generator\Instrument\Effect\Envelope;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock;

class MonoBass extends Instrument
{
    protected function initializeKey(float $frequency, Clock $clock): Generator
    {
        $stack = new Stack();
        $stack->push(new Base($frequency, 1, 0, $clock, Base::SHAPE_TRIANGLE));
        $stack->push(new Base($frequency / 2, .4, 1, $clock, Base::SHAPE_TRIANGLE));

        return $stack;
    }

    protected function buildEffects(Generator $generator, Clock $clock): Effect
    {
        $eff = new Envelope($generator, $clock);
        $eff->setAttackTime(.02);
        $eff->setDecayTime(.7);
        $eff->setSustainAmplitude(0);
        $eff->setReleaseTime(.1);

        return $eff;
    }
}
