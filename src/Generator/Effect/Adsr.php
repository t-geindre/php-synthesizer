<?php

namespace Synthesizer\Generator\Effect;

use Synthesizer\Generator\Generator;

class Adsr implements Effect
{
    public function __construct(Generator $generator, int $sampleRate)
    {
    }

    public function configure(array $config): void
    {
        // TODO: Implement configure() method.
    }

    public function start(): void
    {
        // TODO: Implement start() method.
    }

    public function stop(): void
    {
        // TODO: Implement stop() method.
    }

    public function isOver(): bool
    {
        // TODO: Implement isOver() method.
    }

    public function getValue(): float
    {
        // TODO: Implement getValue() method.
    }
}
