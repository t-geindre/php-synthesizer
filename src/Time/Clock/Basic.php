<?php
namespace Synthesizer\Time\Clock;

class Basic implements Clock
{
    protected float $time = 0;
    private float $tickDuration = 1; // micro secs

    /**
     * @param float $tickDuration Milliseconds
     */
    public function __construct(float $tickDuration)
    {
        $this->tickDuration = $tickDuration * 1000;
    }

    public function tick() : void
    {
        $this->time += $this->tickDuration;
    }

    /**
     * @return float milliseconds
     */
    public function getTime() : float
    {
        return $this->time / 1000;
    }

    public function getMicroSecondsTime(): float
    {
        return $this->time;
    }
}
