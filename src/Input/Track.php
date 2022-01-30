<?php

namespace Synthesizer\Input;

use Synthesizer\Generator\Generator;
use Synthesizer\Generator\Instrument\Instrument;
use Synthesizer\Input\Handler\Basic;
use Synthesizer\Input\Handler\Handler;
use Synthesizer\Input\Producer\Producer;
use Synthesizer\Input\Producer\TimedProducer;
use Synthesizer\Time\Clock\Clock;

class Track implements Generator
{
    private Clock $clock;
    private float $amplitude;
    private Handler $handler;
    /** @var TimedProducer[] */
    private $producers = [];
    private int $length = 0;
    private int $index = 0;
    private int $maxIndex = 0;
    private ?TimedProducer $producer = null;

    public function __construct(Handler $handler, Clock $clock, float $amplitude = 1)
    {
        $this->clock = $clock;
        $this->amplitude = $amplitude;
        $this->handler = $handler;

        $this->reset();
    }

    public static function withBasicHandler(Instrument $instrument, Clock $clock, float $amplitude = 1): self
    {
        return new self(new Basic($instrument), $clock, $amplitude);
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setAmplitude(float $amplitude): void
    {
        $this->amplitude = $amplitude;
    }

    public function addAt(int $at, Producer $producer) : void
    {
        $this->producers[] = new TimedProducer($producer, $at);
        $this->validate();
    }

    public function append(Producer $producer): void
    {
        $this->addAt($this->length === 0 ? 0 : $this->length + 1, $producer);
    }

    public function appendAll(Producer ...$producers): void
    {
        foreach ($producers as $producer) {
            $this->append($producer);
        }
    }

    public function appendAllAt(int $at, Producer ...$producers): void
    {
        foreach ($producers as $producer) {
            if (null !== $at) {
                $this->addAt($at, $producer);
                $at = null;
                continue;
            }
            $this->append($producer);
        }
    }

    private function validate(): void
    {
        usort(
            $this->producers,
            fn(TimedProducer $a, TimedProducer $b) => $a->getAt() <=> $b->getAt()
        );

        $this->length = 0;
        foreach ($this->producers as $producer) {
            if ($this->length === Producer::INFINITE_LENGTH || $producer->getAt() < $this->length) {
                throw new \InvalidArgumentException('Track producers overlap');
            }

            if ($producer->getLength() === Producer::INFINITE_LENGTH) {
                $this->length = Producer::INFINITE_LENGTH;
                continue;
            }

            $this->length += $producer->getLength() + $producer->getAt() - $this->length;
        }

        $this->maxIndex = count($this->producers);
    }

    public function reset(): void
    {
        $this->index = 0;
        $this->producer = null;
    }

    public function isOver() : bool
    {
        if (null !== $this->producer && !$this->producer->isOver()) {
            return false;
        }

        return $this->index >= $this->maxIndex && $this->handler->getInstrument()->isOver();
    }

    private function updateProducer(int $time): void
    {
        if ($this->producer !== null && !$this->producer->isOver()) {
            return;
        }

        $this->producer = null;

        if ($this->index >= $this->maxIndex) {
            return;
        }

        $nextProducer = $this->producers[$this->index];
        if ($time >= $nextProducer->getAt()) {
            $this->index++;
            $this->producer = $nextProducer;
            $this->producer->reset();
        }
    }

    public function getValue(): float
    {
        $time = (int) $this->clock->getTime();

        if (null !== $this->producer) {
            $this->handler->handleMessages(
                $this->producer->pullMessages($time - $this->producer->getAt())
            );
        }

        $this->updateProducer($time);

        return $this->handler->getInstrument()->getValue() * $this->amplitude;
    }
}
