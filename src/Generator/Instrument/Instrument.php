<?php
namespace Synthesizer\Generator\Instrument;

use Synthesizer\Generator\Effect\Effect;
use Synthesizer\Generator\Effect\VoidEffect;
use Synthesizer\Generator\Envelope\Envelope;
use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Oscillator\Oscillator;
use Synthesizer\Generator\Reference\NotesFrequencies;
use Synthesizer\Generator\Stack;
use Synthesizer\Time\Clock\Clock;

abstract class Instrument implements Generator
{
    private Clock $clock;

    /** @var Generator[] */
    private array $keys;

    /** @var Envelope[] */
    private array $keysDown = [];

    /** @var Envelope[] */
    private array $sustainedKeys = [];

    private Stack $generatorsStack;

    private Effect $generator;

    private bool $isSustainOn = false;

    const VELOCITY_MAX = 127;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
        $this->generatorsStack = new Stack();

        $this->initializeKeys();

        $this->generator = $this->addEffects($this->generatorsStack, $clock);
    }

    public function getValue() : float
    {
        if (!$this->isSustainOn) {
            foreach ($this->sustainedKeys as $key => $generator) {
                $generator->noteOff();
                unset($this->sustainedKeys[$key]);
            }
        }

        $this->generatorsStack->clearOver();

        return $this->generator->getValue();
    }

    public function isOver() : bool
    {
        return $this->generatorsStack->isOver();
    }

    public function noteOn(string $key, int $velocity = self::VELOCITY_MAX) : void
    {
        if (!isset($this->keys[$key])) {
            throw new \InvalidArgumentException(sprintf('Unknown note "%s"', $key));
        }

        if (isset($this->sustainedKeys[$key])) {
            $this->sustainedKeys[$key]->noteOff();
            unset($this->sustainedKeys[$key]);
        }

        if (isset($this->keysDown[$key])) {
            $this->noteOff($key);
        }

        $this->keysDown[$key] = $generator = $this->getEnvelope($this->keys[$key], $this->clock);
        $generator->noteOn($velocity / self::VELOCITY_MAX);

        $this->generatorsStack->push($generator);
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

    private function initializeKeys() : void
    {
        foreach (NotesFrequencies::FREQUENCIES as $key => $frequency) {
            $this->keys[$key] = $this->initializeKey($frequency, $this->clock);
        }
    }

    protected function getEnvelope(Generator $generator, Clock $clock) : Envelope
    {
        return Envelope::linear($generator, $clock, 100, 100, 1, 100);
    }

    protected function addEffects(Generator $generator, Clock $clock): Effect
    {
        return new VoidEffect($generator);
    }

    protected abstract function initializeKey(float $frequency, Clock $clock) : Oscillator;
}
