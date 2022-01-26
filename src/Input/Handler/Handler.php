<?php

namespace Synthesizer\Input\Handler;

use Synthesizer\Generator\Instrument\Instrument;
use Synthesizer\Input\Message;

interface Handler
{
    public function handleMessage(Message $message): void;

    /**
     * @param Message[] $messages
     */
    public function handleMessages(array $messages): void;

    public function setInstrument(Instrument $instrument): void;

    public function getInstrument(): Instrument;
}
