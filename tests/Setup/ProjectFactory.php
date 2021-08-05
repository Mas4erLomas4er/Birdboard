<?php


namespace Tests\Setup;


use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{
    protected $tasksCount = 0;
    protected $user = null;

    public function withTasks ($count)
    {
        $this->tasksCount = $count;

        return $this;
    }

    public function ownedBy (User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Project
     */
    public function create () : Project
    {
        $project = Project::factory()->create([
            'owner_id' => $this->user ?: User::factory(),
        ]);

        $tasks = Task::factory($this->tasksCount)->create([
            'project_id' => $project->id,
        ]);

        return $project;
    }
}
