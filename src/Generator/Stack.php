<?php

namespace Synthesizer\Generator;

class Stack implements Generator
{
    /** @var Generator[] */
    private $generators = [];

    private int $mode;
    const MODE_ADDITIVE = 1;
    const MODE_SUBTRACTIVE = -1;

    public function __construct(int $mode = self::MODE_ADDITIVE)
    {
        $this->mode = $mode;
    }

    public function push(Generator $generator): void
    {
        $this->generators[] = $generator;
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
        return array_reduce(
            $this->generators,
            fn (float $carry, Generator $generator) => $carry + $generator->getValue() * $this->mode,
            0.0
        );
    }

    public function clearOver(): void
    {
        foreach ($this->generators as $id => $generator) {
            if ($generator->isOver()) {
                unset($this->generators[$id]);
            }
        }
    }
}
