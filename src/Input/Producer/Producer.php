<?php

namespace Synthesizer\Input\Producer;

use Synthesizer\Input\Message;

interface Producer
{
    const INFINITE_LENGTH = -1;

    /**
     * @return Message[]
     */
    public function pullMessages(int $time): array;

    public function getLength(): int;

    public function isOver(): bool;

    public function reset(): void;
}
