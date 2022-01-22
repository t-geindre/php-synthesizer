<?php

namespace Synthesizer\Generator\Instrument\Effect;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class Delay implements Effect
{
    private Generator $generator;
    private Clock $clock;
    /** @var \SplQueue<float> */
    private \SplQueue $samples;
    private int $samplesCount = 0;
    private float $startTime;
    private $noteOn = false;

    public function __construct(Generator $generator, Clock $clock, float $delay = .1)
    {
        $this->generator = $generator;
        $this->clock = $clock;
        $this->startTime = $clock->getTime() + $delay;
        $this->samples = new \SplQueue();
    }

    public function isOver(): bool
    {
        return $this->generator->isOver() && $this->samplesCount === 0;
    }

    public function getValue(): float
    {
        if ($this->noteOn || !$this->generator->isOver()) {
            $this->samples->enqueue($this->generator->getValue());
            $this->samplesCount++;
        }

        if ($this->clock->getTime() >= $this->startTime) {
            $this->samplesCount--;

            return $this->samples->dequeue();
        }

        return 0;
    }

    public function noteOn(float $velocity): void
    {
        if ($this->generator instanceof Effect) {
            $this->generator->noteOn($velocity);
        }

        $this->noteOn = true;
    }

    public function noteOff(): void
    {
        if ($this->generator instanceof Effect) {
            $this->generator->noteOff();
        }

        $this->noteOn = false;
    }
}
