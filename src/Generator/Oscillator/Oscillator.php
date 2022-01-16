<?php

namespace Synthesizer\Generator\Oscillator;

use Synthesizer\Generator\Generator;
use Synthesizer\Time\Clock;

class Oscillator implements Generator
{
    private Clock $clock;
    private float $frequency;
    private float $amplitude;
    private int $shape;
    private ?Oscillator $lfo = null;
    private float $lastValue = 0;

    const SHAPE_ANALOGIC_SAW = 1;
    const SHAPE_DIGITAL_SAW = 2;
    const SHAPE_NOISE = 3;
    const SHAPE_SINUSOIDAL = 4;
    const SHAPE_SQUARE = 5;
    const SHAPE_TRIANGLE = 6;

    public function __construct(
        float $frequency,
        float $amplitude,
        Clock $clock,
        int $shape = self::SHAPE_SINUSOIDAL
    ) {
        $this->shape = $shape;
        $this->clock = $clock;
        $this->frequency = $frequency;

        $this->amplitude = $amplitude;
    }

    public function getValue() : float
    {
        $this->lastValue = call_user_func([$this, [
            self::SHAPE_ANALOGIC_SAW => 'getAnalogicSawValue',
            self::SHAPE_DIGITAL_SAW => 'getDigitalSawValue',
            self::SHAPE_NOISE => 'getNoiseValue',
            self::SHAPE_SQUARE => 'getSquareValue',
            self::SHAPE_TRIANGLE => 'getTriangleValue',
        ][$this->shape] ?? 'getSinusoidalValue']) * $this->getAmplitude();

        return $this->lastValue;
    }

    private function getCurrentAngle() : float
    {
        $angle = 2 * pi() * $this->frequency * $this->clock->getTime();

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
            * ($this->frequency * pi() * fmod($this->clock->getTime(), 1.0 / $this->frequency)
            - (pi() / 2.0));
    }

    private function getSquareValue() : float
    {
        return $this->getSinusoidalValue() > 0 ? 1 : -1;
    }

    private function getNoiseValue() : float
    {
        return mt_rand(0, 1000) / 1000;
    }

    private function getAnalogicSawValue()
    {
        $value = 0;

        for ($i = 1; $i < 20; $i++) {
            $value += (sin($i * $this->getCurrentAngle())) / $i;
        }

        return $value * (2.0 / pi());
    }

    private function getTriangleValue() : float
    {
        return asin($this->getSinusoidalValue()) * (2/pi());
    }

    public function isOver(): bool
    {
        switch($this->shape) {
            case self::SHAPE_ANALOGIC_SAW:
            case self::SHAPE_DIGITAL_SAW:
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

    public function setLfo(?Oscillator $lfo): void
    {
        $this->lfo = $lfo;
    }
}
