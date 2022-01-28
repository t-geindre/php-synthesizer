<?php

namespace Synthesizer\Generator;

class Stack implements Generator
{
    /** @var \SplObjectStorage<Generator, null> */
    private \SplObjectStorage $generators;

    public function __construct()
    {
        $this->generators = new \SplObjectStorage();
    }

    public function push(Generator $generator): void
    {
        $this->generators->attach($generator);
    }

    public function isOver(): bool
    {
        foreach ($this->generators as $generator) {
            if (!$generator->isOver()) {
                return false;
            }
        }
        return true;
    }

    public function getValue(): float
    {
        $value = 0;
        foreach ($this->generators as $generator) {
            $value += $generator->getValue();
        }

        return $value;
    }

    public function clearOver(): void
    {
        foreach ($this->generators as $generator) {
            if ($generator->isOver()) {
                $this->generators->detach($generator);
            }
        }
    }

    public function contains(Generator $generator): bool
    {
        return $this->generators->contains($generator);
    }
}
