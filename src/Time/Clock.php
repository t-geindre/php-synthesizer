<?php
namespace Synthesizer\Time;

class Clock
{
    protected float $time = 0;
    private float $tickDuration = 1; // micro secs

    public function __construct(float $tickDuration)
    {
        $this->tickDuration = $tickDuration * 1000000;
    }

    public function tick() : void
    {
        $this->time += $this->tickDuration;
    }

    public function getTime() : float
    {
        return $this->time / 1000000;
    }
}
