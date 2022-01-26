<?php

namespace Synthesizer\Input\Producer;

class TimedProducer implements Producer
{
    private Producer $producer;
    private int $at;

    public function __construct(Producer $producer, int $at)
    {
        $this->producer = $producer;
        $this->at = $at;
    }

    public function getAt(): int
    {
        return $this->at;
    }

    public function pullMessages(int $time): array
    {
        return $this->producer->pullMessages($time);
    }

    public function getLength(): int
    {
        return $this->producer->getLength();
    }

    public function isOver(): bool
    {
        return $this->producer->isOver();
    }

    public function reset(): void
    {
        $this->producer->reset();
    }
}
