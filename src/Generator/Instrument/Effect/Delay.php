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
    private float $amplitude;

    public function __construct(Generator $generator, Clock $clock, float $delay = .1, float $amplitude = .1)
    {
        $this->generator = $generator;
        $this->clock = $clock;
        $this->startTime = $clock->getTime() + $delay;
        $this->samples = new \SplQueue();
        $this->amplitude = $amplitude;
    }

    public function isOver(): bool
    {
        return $this->generator->isOver() && $this->samplesCount === 0;
    }

    public function getValue(): float
    {
        $value = $this->generator->getValue();

        if ($this->clock->getTime() >= $this->startTime) {
            $this->samplesCount--;

            $value += $this->samples->dequeue() * $this->amplitude;
        }

        if ($this->noteOn || !$this->generator->isOver()) {
            $this->samples->enqueue($value);
            $this->samplesCount++;
        }


        return $value;
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
