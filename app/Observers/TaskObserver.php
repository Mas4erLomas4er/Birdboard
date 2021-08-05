<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     *
     * @param Task $task
     * @return void
     */
    public function created (Task $task)
    {
        $task->recordActivity('created_task');
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param Task $task
     * @return void
     */
    public function updated (Task $task)
    {
        if ($task->completed == $task->getOriginal()['completed'])
            return;
        $type = $task->completed ? 'completed_task' : 'uncompleted_task';
        $task->recordActivity($type);
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param Task $task
     * @return void
     */
    public function deleted (Task $task)
    {
        $task->recordActivity('deleted_task');
    }
}
