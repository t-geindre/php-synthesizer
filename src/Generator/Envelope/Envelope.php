<?php

namespace Synthesizer\Generator\Envelope;

use Synthesizer\Generator\Envelope\Map\Linear;
use Synthesizer\Generator\Envelope\Map\Map;
use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock\Clock;

class Envelope implements Generator
{
    private Generator $generator;
    private Clock $clock;

    private Map $attack;
    private Map $decay;
    private float $sustain;
    private Map $release;

    private int $phase;
    private const PHASE_ATTACK = 1;
    private const PHASE_DECAY = 2;
    private const PHASE_SUSTAIN = 3;
    private const PHASE_RELEASE = 4;
    private const PHASE_OVER = 5;

	private float $amplitude = 0;
	private float $velocity;

	private float $triggerOnTime = 0;
	private float $triggerOffTime = 0;

    public function __construct(
        Generator $generator,
        Clock $clock,
        Map $attack,
        Map $decay,
        float $sustain,
        Map $release
    ) {
        $this->generator = $generator;
        $this->clock = $clock;
        $this->setShape($attack, $decay, $sustain, $release);
    }

    public function setShape(Map $attack, Map $decay, float $sustain, Map $release): void
    {
        $stepsByMs = (int) (1 / $this->clock->getTickDuration());
        array_map(fn (Map $map) => $map->setStepByMs($stepsByMs), [$attack, $decay, $release]);

        $this->attack = $attack;
        $this->decay = $decay;
        $this->sustain = $sustain;
        $this->release = $release;
    }

    public function noteOn(float $velocity): void
    {
        $this->phase = self::PHASE_ATTACK;
        $this->triggerOnTime = $this->clock->getTime();
        $this->triggerOffTime = 0;
        $this->velocity = $velocity;
    }

    public function noteOff(): void
    {
        $this->triggerOffTime = $this->clock->getTime();
        $this->phase = self::PHASE_RELEASE;
    }

    public function isOver(): bool
    {
        return $this->generator->isOver() && $this->phase == self::PHASE_OVER;
    }

    public function getValue(): float
    {
        $deltaTime = $this->clock->getTime() - $this->triggerOnTime;

        switch ($this->phase) {
            case self::PHASE_ATTACK:
                $this->amplitude = $this->attack->getAmplitude($this->amplitude, $deltaTime);
                if ($deltaTime >= $this->attack->getDuration()){
                    $this->phase = self::PHASE_DECAY;
                }
                break;

            case self::PHASE_DECAY:
                $deltaTime -= $this->attack->getDuration();
                $this->amplitude = $this->decay->getAmplitude($this->amplitude, $deltaTime);
                if ($deltaTime >= $this->decay->getDuration()){
                    $this->phase = self::PHASE_DECAY;
                }
                break;

            case self::PHASE_SUSTAIN:
                $this->amplitude = $this->sustain;
                if ($this->triggerOffTime > $this->triggerOnTime) {
                    $this->phase = self::PHASE_RELEASE;
                }
                break;

            case self::PHASE_RELEASE:
                $deltaTime = $this->clock->getTime() -$this->triggerOffTime;
                $this->amplitude = $this->release->getAmplitude($this->amplitude, $deltaTime);
                if ($deltaTime >= $this->release->getDuration()){
                    $this->phase = self::PHASE_OVER;
                }
                break;
        }

        return $this->generator->getValue() * $this->amplitude * $this->velocity;
    }

    public static function linear(
        Generator $generator,
        Clock $clock,
        int $attackDuration,
        int $decayDuration,
        float $sustainAmplitude,
        int $releaseDuration
    ): self {
        return new self(
            $generator,
            $clock,
            new Linear(1, $attackDuration),
            new Linear($sustainAmplitude, $decayDuration),
            $sustainAmplitude,
            new Linear(0, $releaseDuration)
        );
    }
}
