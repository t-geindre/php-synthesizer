<?php

namespace Synthesizer\Input\Handler;

use Synthesizer\Generator\Instrument\Instrument;
use Synthesizer\Input\Message;

class CyclingInstrument implements Handler
{
    private Basic $handler;
    /** @var callable[] */
    private array $factories;
    private int $index = 0;
    private int $maxIndex = 0;
    private string $switchKey;
    private string $demoNote;

    /**
     * @param callable[] $instrumentsFactories
     */
    public function __construct(string $switchKey, string $demoNote, array $instrumentsFactories)
    {
        $this->factories = array_values($instrumentsFactories);
        $this->maxIndex = count($this->factories) - 1;
        $this->switchKey = $switchKey;
        $this->demoNote = $demoNote;

        $this->handler = new Basic($this->factories[$this->index]());
    }

    public function handleMessage(Message $message): void
    {
        if ($message->getNote() === $this->switchKey) {
            if ($message->isOn()) {
                $this->index = ++$this->index > $this->maxIndex ? 0 : $this->index;
                $this->handler->setInstrument($this->factories[$this->index]());
                $this->getInstrument()->noteOn($this->demoNote);
            } else {
                $this->getInstrument()->noteOff($this->demoNote);
            }

            return;
        }

        $this->handler->handleMessage($message);
    }

    public function handleMessages(array $messages): void
    {
        foreach ($messages as $message) {
            $this->handleMessage($message);
        }
    }

    public function setInstrument(Instrument $instrument): void
    {
        $this->handler->setInstrument($instrument);
    }

    public function getInstrument(): Instrument
    {
        return $this->handler->getInstrument();
    }
}
