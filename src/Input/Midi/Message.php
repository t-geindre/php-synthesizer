<?php

namespace Synthesizer\Input\Midi;

use bviguier\RtMidi\Message as InputMessage;

class Message
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
    private ?string $note = null;
    private int $velocity;

    public function __construct(InputMessage $message)
    {
        $statusByte = $message->byte(self::STATUS_BYTE);
        $this->channel = ($statusByte & ~self::CHANNEL_MASK) + 1;

        switch ($statusByte >> 4) {
            case self::TYPE_NOTE:
                $this->note = NotesReference::NOTES[$message->byte(self::NOTE_BYTE)] ?? null;
                break;

            case self::TYPE_SUSTAIN:
                $this->note = 'sustain';
                break;
        }

        if (null === $this->note) {
            throw new \InvalidArgumentException('Unsupported MIDI message');
        }

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function getVelocity(): int
    {
        return $this->velocity;
    }
}
