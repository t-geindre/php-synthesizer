<?php
namespace Synthesizer\Time;

class Clock
{
    private float $time = 0;
    private float $tickDuration = 1;

    public function __construct(float $tickDuration)
    {
        $this->tickDuration = $tickDuration;
    }

    public function tick() : void
    {
        $this->time += $this->tickDuration;
    }

    public function getTime() : float
    {
        return $this->time;
    }
}
