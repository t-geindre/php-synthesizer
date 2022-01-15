<?php

namespace Synthesizer\Generator\Effect;

use Synthesizer\Generator\Generator;

interface Effect extends Generator
{
    public function __construct(Generator $generator, int $sampleRate);
    public function configure(array $config) : void;
}
