<?php

namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Effect\Delay;
use Synthesizer\Generator\Effect\Effect;
use Synthesizer\Generator\Envelope;
use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\PolySynth\Unison;
use Synthesizer\Generator\Oscillator\Base;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Oscillator\Stack;

class PolySynth extends Instrument
{
    private Unison $unison;
    private Delay $delay;

    public function __construct()
    {
        parent::__construct();

        $this->unison = new Unison();
    }

    public function getUnison(): Unison
    {
        return $this->unison;
    }

    public function getDelay(): Delay
    {
        return $this->delay;
    }

    protected function getOscillator(float $frequency): Oscillator
    {
        $amplitude = ($voices = $this->unison->getVoices()) === 0 ? 1 : 1 / ($voices + 1);

        $stack = new Stack();
        $stack->push(new Base($frequency, $amplitude, 0, Base::SHAPE_SAWTOOTH));
        $this->unison->addOscillators($frequency, $stack);

        return $stack;
    }

    protected function getEnvelope(Oscillator $generator): Envelope
    {
        return Envelope::linear($generator, 2, 2000, 0, 200);
    }

    protected function addEffects(Generator $generator): Effect
    {
        return $this->delay = new Delay($generator, 300, .3);
    }
}
