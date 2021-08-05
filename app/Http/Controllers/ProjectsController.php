<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\StoreProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index ()
    {
        $projects = auth()->user()->allProjects();

        return view('projects.index', compact('projects'));
    }

    public function show (Project $project)
    {
        $this->authorize('view', $project);

        $activities = $project->activities()
            ->orderByDesc('id')
            ->get();

        return view('projects.show', compact('project', 'activities'));
    }

    public function create ()
    {
        return view('projects.create');
    }

    public function store (StoreProjectRequest $request)
    {
        $project = auth()->user()->projects()
            ->create($request->validated());

        $arr = [1, 2, 3];

        $tasks = collect(request('tasks'))
            ->filter(function ($task) use ($project) {
                return $task['body'];
            })
            ->each(function ($task) use ($project) {
                $project->addTask($task['body']);
            });

        if ($request->wantsJson()) {
            return ['project_path' => $project->path()];
        }

        return redirect($project->path());
    }

    public function edit (Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update (UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect($project->path());
    }

    public function destroy (Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index');
    }
}
