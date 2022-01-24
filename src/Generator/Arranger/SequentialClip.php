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
     *
     * todo add validation
     */
    public function append(array $partition): void
    {
        $timedPartition = [];
        $time = 0;

        foreach ($partition as $line) {
            $maxDuration = 0;
            foreach ($line as [$note, $duration]) {
                $maxDuration = $duration > $maxDuration ? $duration : $maxDuration;
                if ($note !== 'S') {
                    $timedPartition[] = [$note, $time, $duration];
                }
            }
            $time += $maxDuration;
        }

        parent::append($timedPartition);
    }
}
