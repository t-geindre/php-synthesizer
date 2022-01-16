<?php

namespace Synthesizer\Generator\Arranger;

use Synthesizer\Time\Clock;

class SequentialClip extends Clip
{
    private Clock $clock;

    // note, at, duration
    private array $partition = [];

    /**
     * @param array<array<string, int>> $partition Array of notes : [note, duration (ms)]
     *
     * This Clip can only handle one note at a time
     * When a note ends (duration is over), the next note is played.
     * A special note 'S' can be used to introduce a pause before the next note.
     */
    public function __construct(array $partition)
    {
        $timedPartition = [];
        $offset = 0;

        foreach ($partition as [$note, $duration]) {
            if ($note !== 'S') {
                $timedPartition[] = [$note, $offset, $duration];
            }

            $offset += $duration;
        }

        parent::__construct($timedPartition);
    }
}
