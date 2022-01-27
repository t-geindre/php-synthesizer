<?php

namespace Synthesizer\Time\Clock;

interface Clock
{
    public function tick(): void;

    /**
     * @return float milliseconds
     */
    public function getTime(): float;

    public function getMicroSecondsTime(): float;

    public function getTickDuration(): float;
}
