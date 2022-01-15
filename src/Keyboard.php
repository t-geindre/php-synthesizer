<?php
namespace Synthesizer;

use Synthesizer\Generator\Effect\Effect;
use Synthesizer\Generator\Wave\Sinusoidal;

class Keyboard
{
    /** @var array<Sinusoidal>  */
    private array $keys;
    private int $sampleRate;
    /** @var array<Effect> */
    private array $keysDown = [];
    private int $amplitude;
    /** @var array<string, array> */
    private array $effects = [];
    private string $waveClass;

    public function __construct(int $sampleRate, int $amplitude = 1, $waveClass = Sinusoidal::class)
    {
        $this->sampleRate = $sampleRate;
        $this->amplitude = $amplitude;
        $this->waveClass = $waveClass;

        $this->initializeKeys();
    }

    public function addEffect(string $class, array $config = []) : void
    {
        if (!is_subclass_of($class, Effect::class)) {
            throw new \InvalidArgumentException('Effect class must implement '.Effect::class);
        }

        $this->effects[] = [$class, $config];
    }

    public function getValue() : float
    {
        $value = 0; $count = 0;

        foreach ($this->keysDown as $key => $generator) {
            $count++;
            $value += $generator->getValue();

            if ($generator->isOver()) {
                unset($this->keysDown[$key]);
            }
        }

        return $value / $count  * $this->amplitude;
    }

    public function isOver() : bool
    {
        return count($this->keysDown) == 0;
    }

    public function keyDown(string $key) : void
    {
        if (!isset($this->keysDown[$key])) {
            $generator = $this->keys[$key];
            foreach ($this->effects as [$class, $config]) {
                $generator = new $class($generator, $this->sampleRate);
            }
            $this->keysDown[$key] = $generator;
        }
        $this->keysDown[$key]->start();
    }

    public function keyUp(string $key) : void
    {
        $this->keysDown[$key]->stop();
    }

    public function keyUpAll() : void
    {
        foreach ($this->keysDown as $key => $none) {
            $this->keyUp($key);
        }
    }

    private function initializeKeys() {
        $this->keys = [
            'C0' => new $this->waveClass(16.35, $this->sampleRate),
            'D0' => new $this->waveClass(18.35, $this->sampleRate),
            'E0' => new $this->waveClass(20.60, $this->sampleRate),
            'F0' => new $this->waveClass(21.83, $this->sampleRate),
            'G0' => new $this->waveClass(24.50, $this->sampleRate),
            'A0' => new $this->waveClass(27.50, $this->sampleRate),
            'B0' => new $this->waveClass(30.87, $this->sampleRate),
            'C1' => new $this->waveClass(32.70, $this->sampleRate),
            'D1' => new $this->waveClass(36.71, $this->sampleRate),
            'E1' => new $this->waveClass(41.20, $this->sampleRate),
            'F1' => new $this->waveClass(43.65, $this->sampleRate),
            'G1' => new $this->waveClass(49.00, $this->sampleRate),
            'A1' => new $this->waveClass(55.00, $this->sampleRate),
            'B1' => new $this->waveClass(61.74, $this->sampleRate),
            'C2' => new $this->waveClass(65.41, $this->sampleRate),
            'D2' => new $this->waveClass(73.42, $this->sampleRate),
            'E2' => new $this->waveClass(82.41, $this->sampleRate),
            'F2' => new $this->waveClass(87.31, $this->sampleRate),
            'G2' => new $this->waveClass(98.00, $this->sampleRate),
            'A2' => new $this->waveClass(110.00, $this->sampleRate),
            'B2' => new $this->waveClass(123.47, $this->sampleRate),
            'C3' => new $this->waveClass(130.81, $this->sampleRate),
            'D3' => new $this->waveClass(146.83, $this->sampleRate),
            'E3' => new $this->waveClass(164.81, $this->sampleRate),
            'F3' => new $this->waveClass(174.61, $this->sampleRate),
            'G3' => new $this->waveClass(196.00, $this->sampleRate),
            'A3' => new $this->waveClass(220.00, $this->sampleRate),
            'B3' => new $this->waveClass(246.94, $this->sampleRate),
            'C4' => new $this->waveClass(261.63, $this->sampleRate),
            'D4' => new $this->waveClass(293.66, $this->sampleRate),
            'E4' => new $this->waveClass(329.63, $this->sampleRate),
            'F4' => new $this->waveClass(349.23, $this->sampleRate),
            'G4' => new $this->waveClass(392.00, $this->sampleRate),
            'A4' => new $this->waveClass(440.00, $this->sampleRate),
            'B4' => new $this->waveClass(493.88, $this->sampleRate),
            'C5' => new $this->waveClass(523.25, $this->sampleRate),
            'D5' => new $this->waveClass(587.33, $this->sampleRate),
            'E5' => new $this->waveClass(659.25, $this->sampleRate),
            'F5' => new $this->waveClass(698.46, $this->sampleRate),
            'G5' => new $this->waveClass(783.99, $this->sampleRate),
            'A5' => new $this->waveClass(880.00, $this->sampleRate),
            'B5' => new $this->waveClass(987.77, $this->sampleRate),
            'C6' => new $this->waveClass(1046.50, $this->sampleRate),
            'D6' => new $this->waveClass(1174.66, $this->sampleRate),
            'E6' => new $this->waveClass(1318.51, $this->sampleRate),
            'F6' => new $this->waveClass(1396.91, $this->sampleRate),
            'G6' => new $this->waveClass(1567.98, $this->sampleRate),
            'A6' => new $this->waveClass(1760.00, $this->sampleRate),
            'B6' => new $this->waveClass(1975.53, $this->sampleRate),
            'C7' => new $this->waveClass(2093.00, $this->sampleRate),
            'D7' => new $this->waveClass(2349.32, $this->sampleRate),
            'E7' => new $this->waveClass(2637.02, $this->sampleRate),
            'F7' => new $this->waveClass(2793.83, $this->sampleRate),
            'G7' => new $this->waveClass(3135.96, $this->sampleRate),
            'A7' => new $this->waveClass(3520.00, $this->sampleRate),
            'B7' => new $this->waveClass(3951.07, $this->sampleRate),
            'C8' => new $this->waveClass(4186.01, $this->sampleRate),
            'D8' => new $this->waveClass(4698.63, $this->sampleRate),
            'E8' => new $this->waveClass(5274.04, $this->sampleRate),
            'F8' => new $this->waveClass(5587.65, $this->sampleRate),
            'G8' => new $this->waveClass(6271.93, $this->sampleRate),
            'A8' => new $this->waveClass(7040.00, $this->sampleRate),
            'B8' => new $this->waveClass(7902.13, $this->sampleRate),
        ];
    }
}
