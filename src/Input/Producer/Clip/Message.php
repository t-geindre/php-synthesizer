<?php

namespace Synthesizer\Input\Producer\Clip;

use Synthesizer\Input\Message as MessageInterface;

class Message implements MessageInterface
{
    private bool $isOn;
    private string $note;
    private int $velocity;
    private int $channel;

    public function __construct(bool $isOn, string $note, int $velocity = 127, int $channel = 1)
    {
        $this->isOn = $isOn;
        $this->note = $note;
        $this->velocity = $velocity;
        $this->channel = $channel;
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
