<?php

namespace Synthesizer\Input\Midi;

use bviguier\RtMidi\Input;
use bviguier\RtMidi\MidiBrowser;

class Device
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

    /**
     * @return Message[]
     */
    public function pullMessages() : array
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
}
