<?php
namespace Synthesizer\Time;

class RealTimeClock extends Clock
{
    private float $startTime;
    private int $goAhead;

    public function __construct(float $tickDuration = 1, int $goAhead = 100)
    {
        parent::__construct($tickDuration);

        $this->startTime = microtime(true) * 1000000;
        $this->goAhead = $goAhead;
    }

    public function tick() : void
    {
        parent::tick();
        $this->wait();
    }

    private function wait(): void
    {
        $realTime = microtime(true) * 1000000 - $this->startTime;
        if ($this->time - $realTime > $this->goAhead) {
            usleep(1);
        }
    }
}
