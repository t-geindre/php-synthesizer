<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Effect\Effect;
use Synthesizer\Generator\Instrument\Effect\Envelope;
use Synthesizer\Generator\Instrument\Effect\Reverberation;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Filter\FirLowPass;
use Synthesizer\Generator\Oscillator\Stack;
use Synthesizer\Time\Clock;

class PolySynth extends Instrument
{
    protected function initializeKey(float $frequency, Clock $clock): Generator
    {
        $ref = new Base($frequency, 0.6, 0, $clock, Base::SHAPE_DIGITAL_SAW);

        $stack = new Stack();
        $stack->push($ref);

        for ($i = 1; $i < 4; $i += 2) {
            $stack->push(new Base($frequency + $i, 0.2, $i * 2, $clock, Base::SHAPE_SQUARE));
            $stack->push(new Base($frequency - $i, 0.2, $i * 2, $clock, Base::SHAPE_SQUARE));
        }

        return new FirLowPass($stack, .6);
    }

    protected function buildEffects(Generator $generator, Clock $clock): Effect
    {
        $eff = new Envelope($generator, $clock);
        $eff->setAttackTime(.05);
        $eff->setDecayTime(.2);
        $eff->setSustainAmplitude(.8);
        $eff->setReleaseTime(.3);

        $eff = new Reverberation($eff, $clock);

        return $eff;
    }
}
