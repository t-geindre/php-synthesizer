<?php

namespace Synthesizer\Generator\Effect;

use Synthesizer\Generator\Generator;

class Attack implements Effect
{
    private Generator $generator;
    private int $sampleRate;

    // Effect settings
    private float $incVelocity = 200;
    private float $decVelocity = -130;
    private float $amplitudeCrete = 1.2;

    // Current state
    private const INCREASE = 1;
    private const DECREASE = 2;
    private const OVER = 3;
    private float $currentAmplitude = 0;
    private int $currentPhase = self::INCREASE;


    public function __construct(Generator $generator, int $sampleRate)
    {
        $this->generator = $generator;
        $this->sampleRate = $sampleRate;
    }

    public function getValue(): float
    {
        $this->updateAmplitude();

        return $this->generator->getValue() * $this->currentAmplitude;
    }

    public function start(): void
    {
        $this->generator->start();

        $this->currentPhase = self::INCREASE;
    }

    public function stop(): void
    {
        $this->generator->stop();

        $this->currentAmplitude = 1;
        $this->currentPhase = self::OVER;
    }

    public function isOver(): bool
    {
        return $this->generator->isOver() && $this->currentPhase === self::OVER;
    }

    private function updateAmplitude() : void
    {
        if ($this->currentPhase === self::OVER) {
            return;
        }

        if ($this->currentPhase === self::INCREASE) {
            $this->currentAmplitude += ($this->incVelocity / $this->sampleRate);
            if ($this->currentAmplitude >= $this->amplitudeCrete) {
                $this->currentAmplitude = $this->amplitudeCrete;
                $this->currentPhase = self::DECREASE;
            }

            return;
        }

        $this->currentAmplitude += ($this->decVelocity / $this->sampleRate);
        if ($this->currentAmplitude <= 1) {
            $this->currentAmplitude = 1;
            $this->currentPhase = self::OVER;
        }
    }

    public function configure(array $config): void
    {
        // TODO: Implement configure() method.
    }
}
