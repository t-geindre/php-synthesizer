<?php

namespace Synthesizer\Automation\Task;

use Synthesizer\Output\Output;
use Synthesizer\Shape\Linear;
use Synthesizer\Shape\Shape;

class FadeOut implements Task
{
    private int $startTime;
    private int $endTime;
    private Output $output;
    private Shape $shape;

    public function __construct(int $startTime, int $endTime, Output $output, ?Shape $shape = null)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->output = $output;
        $this->shape = $shape ?? new Linear(0, $endTime - $startTime);
        $this->shape->setValueFrom($output->getVolume());
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
        $this->output->setVolume((int) $this->shape->getValue($deltaTime));
    }
}
