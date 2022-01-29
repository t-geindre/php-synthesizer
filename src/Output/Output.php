<?php

namespace Synthesizer\Output;

use Synthesizer\Time\Clock\Clock;

interface Output
{
    public function setVolume(int $volume): void;

    public function getVolume(): int;

    public function getClock(): Clock;

    public function setClock(Clock $clock): void;

    public function addSample(float $sample): void;

    public function getSampleRate(): int;
}
