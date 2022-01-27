<?php

namespace Synthesizer\Generator;

class Stack implements Generator
{
    /** @var \SplObjectStorage<Generator, null> */
    private \SplObjectStorage $generators;

    private int $mode;
    const MODE_ADDITIVE = 1;
    const MODE_SUBTRACTIVE = -1;

    public function __construct(int $mode = self::MODE_ADDITIVE)
    {
        $this->generators = new \SplObjectStorage();
        $this->mode = $mode;
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
            $value += $generator->getValue() * $this->mode;
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
