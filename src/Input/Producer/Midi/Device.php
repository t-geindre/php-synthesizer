<?php

namespace Synthesizer\Input\Producer\Midi;

use bviguier\RtMidi\Input;
use bviguier\RtMidi\MidiBrowser;
use Synthesizer\Input\Producer\Producer;

class Device implements Producer
{
    private Input $input;
    /** @var \bviguier\RtMidi\Message[]  */
    private array $queuedMessages;

    /**
     * @param array<\bviguier\RtMidi\Message> $queuedMessages
     */
    public function __construct(string $input, array $queuedMessages = [])
    {
        $this->input = (new MidiBrowser())->openInput($input);
        $this->queuedMessages = $queuedMessages;
    }

    public function pullMessages(int $time) : array
    {
        $messages = [];

        if (count($this->queuedMessages)) {
            foreach ($this->queuedMessages as $msg) {
                $messages[] = new Message($msg);
            }

            $this->queuedMessages = [];
        }

        while ($msg = $this->input->pullMessage()) {
            $messages[] = new Message($msg);
        }

        return $messages;
    }

    public function getLength(): int
    {
        return Producer::INFINITE_LENGTH;
    }

    public function isOver(): bool
    {
        return false;
    }

    public function reset(): void
    {
    }
}
