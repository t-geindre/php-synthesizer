<?php

namespace Synthesizer\Generator\Instrument\Effect;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class Envelope implements Effect
{
    private Generator $generator;
    private Clock $clock;
    private float $attackTime = 0.150;
	private float $decayTime = 0.10;
	private float $sustainAmplitude = 0.8;
	private float $releaseTime = 0.02;
	private float $startAmplitude = 1.0;
	private float $triggerOffTime = 0.0;
	private float $triggerOnTime = 0.0;
	private bool $isOver = false;

    public function __construct(Generator $generator, Clock $clock)
    {
        $this->generator = $generator;
        $this->clock = $clock;
    }

    public function noteOn(float $velocity): void
    {
        $this->isOver = false;
        $this->triggerOnTime = $this->clock->getTime();
        $this->triggerOffTime = 0;
        $this->startAmplitude = $velocity;
    }

    public function noteOff(): void
    {
        $this->triggerOffTime = $this->clock->getTime();
    }

    public function isOver(): bool
    {
        return $this->generator->isOver() && $this->isOver;
    }

    public function getValue(): float
    {
        $amplitude = 0.0;
        $releaseAmplitude = 0.0;
        $time = $this->clock->getTime();
        $isOn = $this->triggerOnTime > $this->triggerOffTime;

        if ($isOn) // Note is on
        {
            $lifeTime = $time - $this->triggerOnTime;

            if ($lifeTime <= $this->attackTime)
                $amplitude = ($lifeTime / $this->attackTime) * $this->startAmplitude;

            if ($lifeTime > $this->attackTime && $lifeTime <= ($this->attackTime + $this->decayTime))
                $amplitude = (($lifeTime - $this->attackTime) / $this->decayTime) * ($this->sustainAmplitude - $this->startAmplitude) + $this->startAmplitude;

            if ($lifeTime > ($this->attackTime + $this->decayTime))
                $amplitude = $this->sustainAmplitude;
        }
        else // Note is off
        {
            $lifeTime = $this->triggerOffTime - $this->triggerOnTime;

            if ($lifeTime <= $this->attackTime)
                $releaseAmplitude = ($lifeTime / $this->attackTime) * $this->startAmplitude;

            if ($lifeTime > $this->attackTime && $lifeTime <= ($this->attackTime + $this->decayTime))
                $releaseAmplitude = (($lifeTime - $this->attackTime) / $this->decayTime) * ($this->sustainAmplitude - $this->startAmplitude) + $this->startAmplitude;

            if ($lifeTime > ($this->attackTime + $this->decayTime))
                $releaseAmplitude = $this->sustainAmplitude;

            $amplitude = (($time - $this->triggerOffTime) / $this->releaseTime) * (0.0 - $releaseAmplitude) + $releaseAmplitude;
        }

        // Amplitude should not be negative
        if ($amplitude <= 0.01) {
            $amplitude = 0.0;
            if (!$isOn) {
                $this->isOver = true;
            }
        }

        return $this->generator->getValue() * $amplitude;
    }

    public function setAttackTime(float $attackTime): void
    {
        $this->attackTime = $attackTime;
    }

    public function setDecayTime(float $decayTime): void
    {
        $this->decayTime = $decayTime;
    }

    public function setSustainAmplitude(float $sustainAmplitude): void
    {
        $this->sustainAmplitude = $sustainAmplitude;
    }

    public function setReleaseTime(float $releaseTime): void
    {
        $this->releaseTime = $releaseTime;
    }

    public function setStartAmplitude(float $startAmplitude): void
    {
        $this->startAmplitude = $startAmplitude;
    }
}
