<?php

namespace Synthesizer\Generator\Arranger;

use Synthesizer\Time\Clock;

class Clip
{
    private Clock $clock;

    // note, at, duration
    private array $partition = [

    ];

    public function __construct(array $partition)
    {
        $this->partition = $partition;
    }

    public function isOver() : bool
    {
        return count($this->partition) == 0;
    }

    public function getNotes(float $time) : array
    {
        $notes = [];

        foreach ($this->partition as $key => [$note, $at, $duration]) {
            if ($at / 1000 < $time) {
                $notes[] = [$note, $duration];
                unset($this->partition[$key]);
            }
        }

        return $notes;
    }
}
