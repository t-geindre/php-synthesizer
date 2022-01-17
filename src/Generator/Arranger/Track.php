<?php

namespace Synthesizer\Generator\Arranger;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Instrument;
use Synthesizer\Time\Clock;

class Track implements Generator
{
    private Instrument $instrument;
    private Clock $clock;
    /** @var array<int, Clip> */
    private array $clips = [];
    private ?Clip $playingClip = null;
    private int $playingClipAt = 0;
    /** @var array<string, float> */
    private array $playingNotes = [];
    private float $amplitude;

    public function __construct(Instrument $instrument, Clock $clock, float $amplitude = 1)
    {
        $this->instrument = $instrument;
        $this->clock = $clock;
        $this->amplitude = $amplitude;
    }

    public function addClip(int $at, Clip $clip) : void
    {
        $this->clips[$at] = $clip;
    }

    public function isOver(): bool
    {
        return count($this->clips) === 0 && $this->playingClip === null && $this->instrument->isOver();
    }

    public function getValue(): float
    {
        $time = $this->clock->getTime();

        foreach ($this->clips as $at => $clip) {
            if ($at / 1000.0 < $time) {
                $this->playingClipAt = $at;
                $this->playingClip = $clip;
                unset($this->clips[$at]);
            }
        }

        if ($this->playingClip !== null) {
            if ($this->playingClip->isOver()) {
                $this->playingClip = null;
            } else {
                $notes = $this->playingClip->getNotes($time - $this->playingClipAt / 1000);
                /** @var string $note */
                foreach ($notes as [$note, $duration]) {
                    if (isset($this->playingNotes[$note])) {
                        $this->instrument->keyUp($note);
                    }
                    $this->playingNotes[$note] = $time + $duration / 1000;
                    $this->instrument->keyDown($note);
                }
            }
        }

        foreach ($this->playingNotes as $note => $endsAt) {
            if ($endsAt < $time) {
                $this->instrument->keyUp($note);
                unset($this->playingNotes[$note]);
            }
        }

        return $this->instrument->getValue() * $this->amplitude;
    }
}
