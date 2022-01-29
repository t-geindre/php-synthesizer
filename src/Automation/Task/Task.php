<?php

namespace Synthesizer\Automation\Task;

interface Task
{
    public function getStartTime(): int;

    public function getEndTime(): ?int;

    public function apply(float $deltaTime): void;
}
