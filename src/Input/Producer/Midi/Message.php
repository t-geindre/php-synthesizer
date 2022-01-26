<?php

namespace Synthesizer\Input\Producer\Midi;

use bviguier\RtMidi\Message as InputMessage;
use Synthesizer\Input\Message as MessageInterface;

class Message implements MessageInterface
{
    const STATUS_BYTE = 0;
    const NOTE_BYTE = 1;
    const VELOCITY_BYTE = 2;

    const TYPE_NOTE = 0b1001;
    const TYPE_SUSTAIN = 0b1011;
    const CHANNEL_MASK = 0b11110000;

    const MAX_VELOCITY = 127;

    private bool $isOn;
    private int $channel;
    private string $note;
    private int $velocity;

    public function __construct(InputMessage $message)
    {
        $statusByte = $message->byte(self::STATUS_BYTE);
        $this->channel = ($statusByte & ~self::CHANNEL_MASK) + 1;

        $note = null;
        switch ($statusByte >> 4) {
            case self::TYPE_NOTE:
                $note = NotesReference::NOTES[$message->byte(self::NOTE_BYTE)] ?? null;
                break;

            case self::TYPE_SUSTAIN:
                $note = self::ACTION_SUSTAIN;
                break;

        }

        if (null === $note) {
            throw new \InvalidArgumentException('Unsupported MIDI message');
        }

        $this->note = $note;
        $this->velocity = $message->byte(self::VELOCITY_BYTE);
        $this->isOn = $this->velocity > 0;

    }

    public function isOn(): bool
    {
        return $this->isOn;
    }

    public function getChannel(): int
    {
        return $this->channel;
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function getVelocity(): int
    {
        return $this->velocity;
    }
}
