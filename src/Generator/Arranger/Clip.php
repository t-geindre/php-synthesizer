<?php

namespace Synthesizer\Generator\Arranger;

class Clip
{
    /** @var array<array<mixed>> */
    private array $partition = [];
    private int $length = 0;
    private int $index = 0;
    private int $maxIndex = 0;

    /**
     * @param array<array<mixed>> $partition Array of notes : [note, at (ms), duration (ms)]
     */
    public function __construct(array $partition)
    {
        $this->append($partition);
    }

    public function isOver() : bool
    {
        return $this->index == $this->maxIndex;
    }

    /**
     * @return array<array<mixed>>
     */
    public function getNotes(float $time) : array
    {
        $notes = [];
        $time *= 1000;

        for (; $this->index < $this->maxIndex; $this->index++) {
            [$note, $at, $duration] = $this->partition[$this->index];
            if ($time >= $at) {
                $notes[] = [$note, $duration];
                continue;
            }
            break;
        }

        return $notes;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getPartition(): array
    {
        return $this->partition;
    }

    public function reset(): void
    {
        $this->index = 0;
    }

    public function append(array $partition): void
    {
        $this->validate($partition);

        if ($this->length > 0) {
            foreach ($partition as &$note) {
                $note[1] += $this->length;
            }
        }

        $this->partition = array_merge($this->partition, $partition);

        uasort($this->partition, fn(array $a, array $b) => $a[1] <=> $b[1]);
        $this->partition = array_values($this->partition);

        $this->maxIndex = count($this->partition) - 1;

        $this->computeLength();
    }

    private function validate(array $partition) : void
    {
        foreach ($partition as $key => $line) {
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

    private function computeLength(): void
    {
        $this->length = 0;
        foreach ($this->partition as $note) {
            $ends = $note[1] + $note[2];
            if ($ends > $this->length) {
                $this->length = $ends;
            }
        }
    }
}
