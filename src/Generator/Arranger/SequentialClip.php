<?php

namespace Synthesizer\Generator\Arranger;

class SequentialClip extends Clip
{
    /**
     * @param array<array<mixed>> $partition Array of notes : [note, duration (ms)]
     *
     * This Clip can only handle one note at a time
     * When a note ends (duration is over), the next note is played.
     * A special note 'S' can be used to introduce a pause before the next note.
     */
    public function append(array $partition): void
    {
        $timedPartition = [];
        $offset = 0;

        foreach ($partition as [$note, $duration]) {
            if ($note !== 'S') {
                $timedPartition[] = [$note, $offset, $duration];
            }

            $offset += $duration;
        }

        parent::append($timedPartition);
    }
}
