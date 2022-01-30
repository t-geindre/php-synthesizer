<?php

namespace Synthesizer\Generator\Effect;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock\Clock;

class Delay implements Effect
{
    private Generator $generator;
    private Clock $clock;
    /** @var \SplQueue<float> */
    private \SplQueue $samples;
    private float $startTime;
    private float $amplitude;

    public function __construct(Generator $generator, Clock $clock, float $delay = .1, float $amplitude = .1)
    {
        if ($delay < 0) {
            throw new \InvalidArgumentException('Delay must be greater than 0');
        }

        $this->generator = $generator;
        $this->clock = $clock;
        $this->startTime = $clock->getTime() + $delay;
        $this->samples = new \SplQueue();
        $this->amplitude = $amplitude;
    }

    public function isOver(): bool
    {
        return $this->generator->isOver();
    }

    public function getValue(): float
    {
        $value = $this->generator->getValue();

        if ($this->clock->getTime() >= $this->startTime) {
            $value += $this->samples->dequeue() * $this->amplitude;
        }

        $this->samples->enqueue($value);

        return $value;
    }

    public  function setAmplitude(float $amplitude): void
    {
        $this->amplitude = $amplitude;
    }
}
