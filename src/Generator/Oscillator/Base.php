<?php

namespace Synthesizer\Generator\Oscillator;

class Base implements Oscillator
{
    private float $frequency;
    private float $amplitude;
    private float $phase;
    private int $shape;
    private ?Oscillator $lfo = null;
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
        int   $shape = self::SHAPE_SINUSOIDAL
    ) {
        $this->shape = $shape;
        $this->frequency = $frequency / 1000;

        $this->amplitude = $amplitude;
        $this->phase = $phase;
    }

    public function getValue(float $deltaTime) : float
    {
        /** @var callable $valueFunction */
        $valueFunction = [$this, [
            self::SHAPE_SAWTOOTH => 'getDigitalSawValue',
            self::SHAPE_NOISE => 'getNoiseValue',
            self::SHAPE_SQUARE => 'getSquareValue',
            self::SHAPE_TRIANGLE => 'getTriangleValue',
        ][$this->shape] ?? 'getSinusoidalValue'];
        $this->lastValue = call_user_func($valueFunction, $deltaTime) * $this->getAmplitude();

        return $this->lastValue;
    }

    private function getCurrentAngle(float $deltaTime) : float
    {
        $angle = 2 * pi() * $this->getLfoAwareFrequency($deltaTime) * $deltaTime + $this->phase;

        return $angle;
    }

    private function getSinusoidalValue(float $deltaTime) : float
    {
        return sin($this->getCurrentAngle($deltaTime));
    }

    private function getDigitalSawValue(float $deltaTime) : float
    {
        return
            (2.0 / pi())
            * ($this->getLfoAwareFrequency($deltaTime) * pi() * fmod($deltaTime + $this->phase, 1.0 / $this->getLfoAwareFrequency($deltaTime))
            - (pi() / 2.0));
    }

    private function getSquareValue(float $deltaTime) : float
    {
        return $this->getSinusoidalValue($deltaTime) > 0 ? 1 : -1;
    }

    private function getNoiseValue(float $deltaTime) : float
    {
        return mt_rand(-1000, 1000) / 1000;
    }

    private function getTriangleValue(float $deltaTime) : float
    {
        return asin($this->getSinusoidalValue($deltaTime)) * (2/pi());
    }

    public function getFrequency(): float
    {
        return $this->frequency;
    }

    public function getLfoAwareFrequency(float $deltaTime): float
    {
        if(null !== $this->lfo) {
            return $this->frequency + $this->lfo->getValue($deltaTime);
        }

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
