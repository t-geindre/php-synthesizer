<?php

namespace Synthesizer\Generator;

use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Shape\Constant;
use Synthesizer\Shape\Linear;
use Synthesizer\Shape\Shape;
use Synthesizer\Time\Clock\Clock;

class Envelope implements Generator
{
    private Oscillator $oscillator;
    private Clock $clock;

    private Shape $attack;
    private Shape $decay;
    private Shape $sustain;
    private Shape $release;

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
        Oscillator $generator,
        Clock      $clock,
        Shape      $attack,
        Shape      $decay,
        Shape      $sustain,
        Shape      $release
    ) {
        $this->oscillator = $generator;
        $this->clock = $clock;
        $this->setShape($attack, $decay, $sustain, $release);
    }

    public function setShape(Shape $attack, Shape $decay, Shape $sustain, Shape $release): void
    {
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
        $this->release->setValueFrom($this->amplitude);
    }

    public function isOver(): bool
    {
        return $this->phase == self::PHASE_OVER;
    }

    public function getValue(): float
    {
        $deltaTime = $this->clock->getTime() - $this->triggerOnTime;

        switch ($this->phase) {
            case self::PHASE_ATTACK:
                $this->amplitude = $this->attack->getValue($deltaTime);
                if ($deltaTime >= $this->attack->getDuration()){
                    $this->phase = self::PHASE_DECAY;
                    $this->decay->setValueFrom($this->amplitude);
                }
                break;

            case self::PHASE_DECAY:
                $decayDeltaTime = $deltaTime - $this->attack->getDuration();
                $this->amplitude = $this->decay->getValue($decayDeltaTime);
                if ($decayDeltaTime >= $this->decay->getDuration()){
                    $this->phase = self::PHASE_SUSTAIN;
                    $this->sustain->setValueFrom($this->amplitude);
                }
                break;

            case self::PHASE_SUSTAIN:
                $this->amplitude = $this->sustain->getValue($deltaTime);
                break;

            case self::PHASE_RELEASE:
                $releaseDeltaTime = $this->clock->getTime() - $this->triggerOffTime;
                $this->amplitude = $this->release->getValue($releaseDeltaTime);
                if ($releaseDeltaTime >= $this->release->getDuration()){
                    $this->phase = self::PHASE_OVER;
                }
                break;
        }

        return $this->oscillator->getValue($deltaTime) * $this->amplitude * $this->velocity;
    }

    public static function linear(
        Oscillator $generator,
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
            new Constant($sustainAmplitude),
            new Linear(0, $releaseDuration)
        );
    }
}
