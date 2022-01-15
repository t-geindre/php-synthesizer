<?php

namespace Synthesizer\Generator\Arranger;

use Synthesizer\Generator\Generator;

class Arranger implements Generator
{
    /** @var array<Track> */
    private array $tracks = [];
    private float $amplitude;

    public function __construct(float $amplitude)
    {
        $this->amplitude = $amplitude;
    }

    public function addTrack(Track $track)
    {
        $this->tracks[] = $track;
    }

    public function isOver(): bool
    {
        foreach ($this->tracks as $track) {
            if (!$track->isOver()) {
                return false;
            }
        }

        return true;
    }

    public function getValue(): float
    {
        $value = 0;

        foreach ($this->tracks as $track) {
            $value += $track->getValue();
        }

        return $value * $this->amplitude;
    }
}
