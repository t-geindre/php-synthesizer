<?php

namespace Synthesizer\Generator\Instrument\Effect;

use Synthesizer\Generator\Generator;

class VoidEffect implements Effect
{
    private Generator $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function isOver(): bool
    {
        return $this->generator->isOver();
    }

    public function getValue(): float
    {
        return $this->generator->getValue();
    }
}
