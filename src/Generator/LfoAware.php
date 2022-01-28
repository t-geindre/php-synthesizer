<?php

namespace Synthesizer\Generator;

use Synthesizer\Generator\Oscillator\Oscillator;

interface LfoAware
{
    public function setLfo(?Oscillator $lfo): void;
}
