<?php

namespace Synthesizer\Input\Producer\Clip;

use Synthesizer\Input\Producer\Producer;
use Synthesizer\Reference\Scaler;

class Clip implements Producer
{
    /** @var array<array<mixed>> */
    private array $partition = [];
    private int $length = 0;
    private int $index = 0;
    private int $maxIndex = 0;
    /** @var array<array<mixed>> */
    private array $playingNotes = [];
    private int $playingCount = 0;

    /**
     * @param array<array<mixed>> $partition Array of notes : [note, at (ms), duration (ms)]
     */
    public function __construct(array $partition)
    {
        $this->append($partition);
    }

    public function isOver() : bool
    {
        return $this->index >= $this->maxIndex && $this->playingCount === 0;
    }

    public function pullMessages(int $time) : array
    {
        $messages = [];

        /**
         * @var string $note
         * @var int $ends
         */
        foreach ($this->playingNotes as $key => [$note, $ends]) {
            if ($time >= $ends) {
                $messages[] = new Message(false, $note);
                $this->playingCount--;
                unset($this->playingNotes[$key]);
            }
        }

        while ($this->index < $this->maxIndex) {
            /**
             * @var string $note
             * @var int $at
             * @var int $duration
             */
            [$note, $at, $duration] = $this->partition[$this->index];
            if ($time >= $at) {
                $messages[] = new Message(true, $note);
                $this->playingNotes[] = [$note, $time + $duration];
                $this->playingCount++;
                $this->index++;
                continue;
            }
            break;
        }

        return $messages;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return array<array<mixed>>
     */
    public function getPartition(): array
    {
        return $this->partition;
    }

    public function reset(): void
    {
        $this->index = 0;
        $this->playingNotes = [];
    }

    /**
     * @param array<array<mixed>> $partition
     */
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

        $this->maxIndex = count($this->partition);

        $this->computeLength();
    }

    public function scale(int $scale): void
    {
        /** @var string $note */
        foreach ($this->partition as [&$note, ]) {
            $note = Scaler::scaleNote($note, $scale);
        }
    }

    /**
     * @param array<array<mixed>> $partition
     */
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
            /** @var int $ends */
            $ends = $note[1] + $note[2];
            if ($ends > $this->length) {
                $this->length = $ends;
            }
        }
    }
}
