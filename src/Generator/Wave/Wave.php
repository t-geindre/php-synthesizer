<?php

namespace Synthesizer\Generator\Wave;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

interface Wave extends Generator
{
    public function __construct(float $frequency, Clock $clock);
}
