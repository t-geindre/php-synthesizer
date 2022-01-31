<?php
namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Effect\Effect;
use Synthesizer\Generator\Effect\VoidEffect;
use Synthesizer\Generator\Envelope;
use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Stack;
use Synthesizer\Reference\Frequencies;

abstract class Instrument implements Generator
{
    /** @var Envelope[] */
    private array $keysDown = [];

    /** @var Envelope[] */
    private array $sustainedKeys = [];

    private Stack $generatorsStack;

    private Effect $generator;

    private bool $isSustainOn = false;

    const VELOCITY_MAX = 127;

    public function __construct()
    {
        $this->generatorsStack = new Stack();

        $this->generator = $this->addEffects($this->generatorsStack);
    }

    public function getValue(float $deltaTime) : float
    {
        if (!$this->isSustainOn) {
            foreach ($this->sustainedKeys as $key => $generator) {
                $generator->noteOff();
                unset($this->sustainedKeys[$key]);
            }
        }

        $this->generatorsStack->clearOver();

        return $this->generator->getValue($deltaTime);
    }

    public function isOver() : bool
    {
        return $this->generatorsStack->isOver();
    }

    public function noteOn(string $key, int $velocity = self::VELOCITY_MAX) : void
    {
        if (!isset(Frequencies::FREQUENCIES[$key])) {
            throw new \InvalidArgumentException(sprintf('Unknown note "%s"', $key));
        }

        if (isset($this->sustainedKeys[$key])) {
            $this->sustainedKeys[$key]->noteOff();
            unset($this->sustainedKeys[$key]);
        }

        if (isset($this->keysDown[$key])) {
            $this->noteOff($key);
        }

        $generator = $this->getOscillator(Frequencies::FREQUENCIES[$key]);
        $generator = $this->getEnvelope($generator);
        $generator->noteOn($velocity / self::VELOCITY_MAX);
        $this->generatorsStack->push($generator);

        $this->keysDown[$key] = $generator  ;

    }

    public function noteOff(string $key) : void
    {
        if (!isset($this->keysDown[$key])) {
            return;
        }

        $generator = $this->keysDown[$key];
        unset($this->keysDown[$key]);

        if ($this->isSustainOn) {
            $this->sustainedKeys[$key] = $generator;

            return;
        }

        $generator->noteOff();
    }

    public function sustainOn(): void
    {
        $this->isSustainOn = true;
    }

    public function sustainOff(): void
    {
        $this->isSustainOn = false;
    }

    public function noteOffAll() : void
    {
        foreach ($this->keysDown as $key => $none) {
            $this->noteOff($key);
        }
    }

    protected function getEnvelope(Oscillator $generator) : Envelope
    {
        return Envelope::linear($generator, 100, 100, 1, 100);
    }

    protected function addEffects(Generator $generator): Effect
    {
        return new VoidEffect($generator);
    }

    protected abstract function getOscillator(float $frequency) : Oscillator;
}
