<?php

namespace Synthesizer\Generator\Effect;

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

    public function getValue(float $deltaTime): float
    {
        return $this->generator->getValue($deltaTime);
    }
}
