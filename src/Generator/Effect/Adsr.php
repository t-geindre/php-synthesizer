<?php

namespace Synthesizer\Generator\Effect;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class Adsr implements Effect
{
    private Generator $generator;
    private Clock $clock;

    public function __construct(Generator $generator, Clock $clock)
    {
        $this->generator = $generator;
        $this->clock = $clock;
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
