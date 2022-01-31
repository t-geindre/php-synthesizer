<?php

namespace Synthesizer\Generator\Effect;

use Synthesizer\Generator\Generator;

class Delay implements Effect
{
    private Generator $generator;
    private float $time = 0;
    /** @var \SplQueue<float> */
    private \SplQueue $samples;
    private float $delay;
    private float $amplitude;

    public function __construct(Generator $generator, float $delay = 300, float $amplitude = .1)
    {
        if ($delay < 0) {
            throw new \InvalidArgumentException('Delay must be greater than 0');
        }

        $this->generator = $generator;
        $this->delay = $delay;
        $this->samples = new \SplQueue();
        $this->amplitude = $amplitude;
    }

    public function isOver(): bool
    {
        return $this->generator->isOver();
    }

    public function getValue(float $deltaTime): float
    {
        $this->time += $deltaTime;
        $value = $this->generator->getValue($deltaTime);

        if ($this->time >= $this->delay) {
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
