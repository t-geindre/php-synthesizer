<?php

namespace Synthesizer\Automation\Task;

class CallableBased implements Task
{
    private int $startTime;
    private ?int $endTime;
    /** @var callable */
    private $applyFunction;

    public function __construct(int $startTime, ?int $endTime, callable $applyFunction)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->applyFunction = $applyFunction;
    }

    public function getStartTime(): int
    {
        return $this->startTime;
    }

    public function getEndTime(): ?int
    {
        return $this->endTime;
    }

    public function apply(float $deltaTime): void
    {
        call_user_func($this->applyFunction, $this->startTime, $this->endTime, $deltaTime);
    }
}
