<?php
namespace Synthesizer\Automation;

use Synthesizer\Automation\Task\CallableBased;
use Synthesizer\Automation\Task\Task;
use Synthesizer\Time\Clock\Clock;

class Automation
{
    /** @var Task[] */
    private array $tasks = [];
    private int $taskIndex = 0;
    private int $tasksLeft = 0;

    /** @var Task[] */
    private array $runningTasks = [];
    private int $runningTasksCount = 0;

    private Clock $clock;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

    public function addInline(int $start, int $end, callable $applyFunction): void
    {
        $this->addTask(new CallableBased($start, $end, $applyFunction));
    }

    public function addTask(Task $task): void
    {
        $this->tasks[] = $task;
        usort($this->tasks, fn(Task $a, Task $b) => $a->getStartTime() <=> $b->getStartTime());
        $this->tasksLeft = count($this->tasks);
    }

    public function update(): void
    {
        $time = $this->clock->getTime();

        while ($this->tasksLeft > 0) {
            $task = $this->tasks[$this->taskIndex];
            if ($task->getStartTime() <= $time) {
                $this->runningTasks[] = $task;
                $this->runningTasksCount++;
                $this->taskIndex++;
                $this->tasksLeft--;
                continue;
            }
            break;
        }

        foreach ($this->runningTasks as $key => $task) {
            $task->apply($time - $task->getStartTime());
            if ($task->getEndTime() <= $time) {
                $this->runningTasksCount--;
                unset($this->runningTasks[$key]);
            }
        }
    }

    public function isOver(): bool
    {
        return $this->tasksLeft == 0 && $this->runningTasksCount === 0;
    }
}
