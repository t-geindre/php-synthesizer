<?php

namespace Synthesizer\Generator\Oscillator;

class Stack implements Oscillator
{
    /** @var \SplObjectStorage<Oscillator, null> */
    private \SplObjectStorage $oscillators;

    public function __construct()
    {
        $this->oscillators = new \SplObjectStorage();
        }

    public function push(Oscillator $oscillator) : void
    {
        $this->oscillators->attach($oscillator);
    }

    public function getValue(float $deltaTime): float
    {
        $value = 0;
        foreach ($this->oscillators as $oscillator) {
            $value += $oscillator->getValue($deltaTime);
        }

        return $value;
    }
}
