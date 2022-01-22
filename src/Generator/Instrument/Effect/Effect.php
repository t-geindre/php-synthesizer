<?php

namespace Synthesizer\Generator\Instrument\Effect;

use Synthesizer\Generator\Generator;

interface Effect extends Generator
{
    public function noteOn(float $velocity): void;

    public function noteOff(): void;
}
