<?php

namespace Synthesizer\Generator\Arranger;

use Synthesizer\Time\Clock;

class Clip
{
    private Clock $clock;

    // note, at, duration
    private array $partition = [];

    /**
     * @param array<array<string, int, int>> $partition Array of notes : [note, at (ms), duration (ms)]
     */
    public function __construct(array $partition)
    {
        $this->partition = $partition;

        $this->validate();
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

    private function validate()
    {
        foreach ($this->partition as $key => $line) {
            if (count($line) !== 3) {
                throw new \InvalidArgumentException(
                    sprintf('Invalid partition, size is "%d" at line "%d", "3" expected', count($line), $key)
                );
            }

            if (!is_string($line[0])) {
                throw new \InvalidArgumentException(
                    sprintf('Invalid partition, string expected at position 0, line %d', $key)
                );
            }

            if (!is_int($line[1]) || !is_int($line[2])) {
                throw new \InvalidArgumentException(
                    sprintf('Invalid partition, int expected at position 1 or 2, line %d', $key)
                );
            }
        }
    }
}
