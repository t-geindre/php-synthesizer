<?php

namespace Synthesizer\Generator\Effect;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class Envelope implements Effect
{
    private Generator $generator;
    private Clock $clock;
    private float $attackTime = 0.10;
	private float $decayTime = 0.10;
	private float $sustainAmplitude = 0.4;
	private float $releaseTime = 0.02;
	private float $startAmplitude = 1.0;
	private float $triggerOffTime = 0.0;
	private float $triggerOnTime = 0.0;
	private bool $isOn = false;
	private bool $isOver = false;

    public function __construct(Generator $generator, Clock $clock)
    {
        $this->generator = $generator;
        $this->clock = $clock;
    }

    public function configure(array $config): void
    {
    }

    public function start(): void
    {
        $this->isOn = true;
        $this->isOver = false;

        $this->triggerOnTime = $this->clock->getTime();
    }

    public function stop(): void
    {
        $this->triggerOffTime = $this->clock->getTime();
        $this->isOn = false;
    }

    public function isOver(): bool
    {
        return $this->isOver;
    }

    public function getValue(): float
    {
        $amplitude = 0.0;
        $time = $this->clock->getTime();
        $lifeTime = $time - $this->triggerOnTime;

        if ($this->isOn) {
            if ($lifeTime <= $this->attackTime) {
                $amplitude = ($lifeTime / $this->attackTime) * $this->startAmplitude;
            }

            if ($lifeTime > $this->attackTime && $lifeTime <= ($this->attackTime + $this->decayTime)) {
                // In decay phase - reduce to sustained amplitude
                $amplitude = (($lifeTime - $this->attackTime) / $this->decayTime) * ($this->sustainAmplitude - $this->startAmplitude) + $this->startAmplitude;
            }

            if ($lifeTime > ($this->attackTime + $this->decayTime)) {
                // In sustain phase - dont change until note released
                $amplitude = $this->sustainAmplitude;
            }
        } else {
            // Note has been released, so in release phase
            $amplitude = (($time - $this->triggerOffTime) / $this->releaseTime) * (0.0 - $this->sustainAmplitude) + $this->sustainAmplitude;
        }

        // Amplitude should not be negative
        if ($amplitude < 0) {
            $this->isOver = true;
            $amplitude = 0.0;
        }

        return $this->generator->getValue() * $amplitude;
    }
}
