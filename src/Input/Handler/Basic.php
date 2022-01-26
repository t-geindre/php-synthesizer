<?php

namespace Synthesizer\Input\Handler;

use Synthesizer\Generator\Instrument\Instrument;
use Synthesizer\Input\Handler\Handler as  MessageHandlerInterface;
use Synthesizer\Input\Message;

class Basic implements MessageHandlerInterface
{
    private Instrument $instrument;

    public function __construct(Instrument $instrument)
    {
        $this->instrument = $instrument;
    }

    public function handleMessage(Message $message): void
    {
        if ($message->getNote() === Message::ACTION_SUSTAIN) {
            if ($message->isOn()) {
                $this->instrument->sustainOn();
            } else {
                $this->instrument->sustainOff();
            }
            return;
        }

        if ($message->isOn()) {
            $this->instrument->noteOn($message->getNote() , $message->getVelocity());
        } else {
            $this->instrument->noteOff($message->getNote());
        }
    }

    public function handleMessages(array $messages): void
    {
        foreach ($messages as $message) {
            $this->handleMessage($message);
        }
    }

    public function setInstrument(Instrument $instrument): void
    {
        $this->instrument = $instrument;
    }

    public function getInstrument(): Instrument
    {
        return $this->instrument;
    }
}
