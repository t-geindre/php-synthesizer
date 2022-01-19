<?php

namespace Synthesizer\Generator\Arranger;

use Synthesizer\Generator\Generator;

class Arranger implements Generator
{
    /** @var Track[] */
    private array $tracks = [];
    private float $amplitude;

    public function __construct(float $amplitude)
    {
        $this->amplitude = $amplitude;
    }

    public function addTrack(Track $track): void
    {
        $this->tracks[] = $track;
    }

    /** @param Track[] $tracks */
    public function addTracks(array $tracks) : void
    {
        foreach ($tracks as $track) {
            $this->addTrack($track);
        }
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
