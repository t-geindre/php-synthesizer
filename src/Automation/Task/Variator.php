<?php

namespace Synthesizer\Automation\Task;

use Synthesizer\Shape\Linear;
use Synthesizer\Shape\Shape;

class Variator implements Task
{
    private int $startTime;
    private int $endTime;
    private Shape $shape;
    /** @var callable */
    private $callback;

    public function __construct(
        int $startTime,
        int $endTime,
        float $from,
        float $to,
        callable  $callback,
        ?Shape $shape = null
    ) {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->shape = $shape ?? new Linear($to, $endTime - $startTime);
        $this->shape->setValueFrom($from);
        $this->callback = $callback;
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
        call_user_func($this->callback, $this->shape->getValue($deltaTime));
    }
}
