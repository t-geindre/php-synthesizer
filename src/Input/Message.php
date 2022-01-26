<?php

namespace Synthesizer\Input;

interface Message
{
    const ACTION_SUSTAIN = 'sustain';

    public function isOn(): bool;

    public function getChannel(): int;

    public function getNote(): string;

    public function getVelocity(): int;
}
