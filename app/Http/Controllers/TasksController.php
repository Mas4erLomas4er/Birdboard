<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TasksController extends Controller
{
    public function store (Project $project)
    {
        $this->authorize('update', $project);

        request()->validate(['body' => ['required', 'max:50']]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update (Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        request()->validate(['body' => ['required', 'max:50']]);

        $task->update(['body' => request('body')]);

        request('completed') ? $task->complete() : $task->incomplete();

        return redirect($task->project->path());
    }
}
