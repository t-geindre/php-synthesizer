<?php
namespace Synthesizer\Time\Clock;

class RealTime implements Clock
{
    private float $startTime;
    private int $goAhead;
    private Clock $clock;

    public function __construct(Clock $clock, int $goAhead = 100)
    {
        $this->clock = $clock;
        $this->startTime = microtime(true) * 1000000;
        $this->goAhead = $goAhead;
    }

    public function tick() : void
    {
        $this->clock->tick();
        $this->wait();
    }

    private function wait(): void
    {
        $realTime = microtime(true) * 1000000 - $this->startTime;
        if ($this->getMicroSecondsTime() - $realTime > $this->goAhead) {
            usleep(1);
        }
    }

    public function getTime(): float
    {
        return $this->clock->getTime();
    }

    public function getMicroSecondsTime(): float
    {
        return $this->clock->getMicroSecondsTime();
    }

    public function getTickDuration(): float
    {
        return $this->clock->getTickDuration();
    }

    public function getDeltaTime(): float
    {
        return $this->clock->getDeltaTime();
    }
}
