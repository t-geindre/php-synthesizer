<?php

namespace Synthesizer\Generator\Effect;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

interface Effect extends Generator
{
    public function __construct(Generator $generator, Clock $clock);
    public function configure(array $config) : void;
}
