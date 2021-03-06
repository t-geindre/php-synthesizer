<?php

namespace Synthesizer\Generator\Oscillator;

use Synthesizer\Time\Clock;

class Base implements Oscillator
{
    private Clock $clock;
    private float $frequency;
    private float $amplitude;
    private float $phase;
    private int $shape;
    private ?Base $lfo = null;
    private float $lastValue = 0;

    const SHAPE_SAWTOOTH = 2;
    const SHAPE_NOISE = 3;
    const SHAPE_SINUSOIDAL = 4;
    const SHAPE_SQUARE = 5;
    const SHAPE_TRIANGLE = 6;

    public function __construct(
        float $frequency,
        float $amplitude,
        float $phase,
        Clock $clock,
        int $shape = self::SHAPE_SINUSOIDAL
    ) {
        $this->shape = $shape;
        $this->clock = $clock;
        $this->frequency = $frequency;

        $this->amplitude = $amplitude;
        $this->phase = $phase;
    }

    public function getValue() : float
    {
        /** @var callable $valueFunction */
        $valueFunction = [$this, [
            self::SHAPE_SAWTOOTH => 'getDigitalSawValue',
            self::SHAPE_NOISE => 'getNoiseValue',
            self::SHAPE_SQUARE => 'getSquareValue',
            self::SHAPE_TRIANGLE => 'getTriangleValue',
        ][$this->shape] ?? 'getSinusoidalValue'];
        $this->lastValue = call_user_func($valueFunction) * $this->getAmplitude();

        return $this->lastValue;
    }

    private function getCurrentAngle() : float
    {
        $angle = 2 * pi() * $this->frequency * $this->clock->getTime() + $this->phase;

        if ($this->lfo !== null) {
            $angle += $this->lfo->getAmplitude() * $this->lfo->getFrequency() * $this->lfo->getValue();
        }

        return $angle;
    }

    private function getSinusoidalValue() : float
    {
        return sin($this->getCurrentAngle());
    }

    private function getDigitalSawValue() : float
    {
        return
            (2.0 / pi())
            * ($this->frequency * pi() * fmod($this->clock->getTime() + $this->phase, 1.0 / $this->frequency)
            - (pi() / 2.0));
    }

    private function getSquareValue() : float
    {
        return $this->getSinusoidalValue() > 0 ? 1 : -1;
    }

    private function getNoiseValue() : float
    {
        return mt_rand(-1000, 1000) / 1000;
    }

    private function getTriangleValue() : float
    {
        return asin($this->getSinusoidalValue()) * (2/pi());
    }

    public function isOver(): bool
    {
        switch($this->shape) {
            case self::SHAPE_SAWTOOTH:
            case self::SHAPE_TRIANGLE:
                return $this->lastValue < 0.001 && $this->lastValue > -0.999;
            default:
                return true;
        }
    }

    public function getFrequency(): float
    {
        return $this->frequency;
    }

    public function getAmplitude(): float
    {
        return $this->amplitude;
    }

    public function setLfo(?Base $lfo): void
    {
        $this->lfo = $lfo;
    }
}
