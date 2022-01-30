<?php

namespace Synthesizer\Generator\Instrument\PolySynth;

use Synthesizer\Generator\Oscillator\Base;use Synthesizer\Generator\Oscillator\Stack;

class Unison
{
    private int $voices = 0;
    private int $shape = Base::SHAPE_SAWTOOTH;
    private float $detuneStep = 0;
    private float $dephaseStep = 0;

    public function setVoices(int $voices): void
    {
        if ($voices % 2 !== 0 || $voices < 0) {
            throw new \InvalidArgumentException(sprintf('Voices must be a positive even number, "%d" given', $voices));
        }

        $this->voices = $voices;
    }

    public function getVoices(): int
    {
        return $this->voices;
    }

    public function setShape(int $shape): void
    {
        $this->shape = $shape;
    }

    public function setDetuneStep(float $detuneStep): void
    {
        $this->detuneStep = $detuneStep;
    }

    public function setDephaseStep(float $dephaseStep): void
    {
        $this->dephaseStep = $dephaseStep;
    }

    public function addOscillators(float $frequencyRef, Stack $stack): void
    {
        $amplitude = 1 / ($this->voices + 1);
        for ($i=1 ; $i <= $this->voices / 2 ; $i++) {
            foreach ([-$i, $i] as $index) {
                $stack->push(new Base(
                    $frequencyRef - $index * $this->detuneStep,
                    $amplitude,
                    abs($index) * $this->dephaseStep,
                    $this->shape
                ));
            }
        }
    }
}
