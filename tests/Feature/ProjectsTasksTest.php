<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectsTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects ()
    {
        $project = ProjectFactory::create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task 123'])->assertRedirect('login');
    }

    /** @test */
    public function a_task_can_be_created ()
    {
        $this->signIn();

        $project = ProjectFactory
            ::ownedBy($this->signIn())
            ->create();

        $this->post($project->path() . '/tasks', ['body' => "Test task"]);

        $this->get($project->path())
            ->assertSee("Test task");
    }

    /** @test */
    public function a_task_can_be_updated ()
    {
        $project = ProjectFactory
            ::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $task = $project->tasks->first();

        $this->patch($task->path(), $data = ['body' => 'changed'])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('tasks', $data);
    }

    /** @test */
    public function a_task_can_be_completed ()
    {
        $project = ProjectFactory
            ::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $task = $project->tasks->first();

        $data = [
            'body' => 'Changed',
            'completed' => true,
        ];

        $this->patch($task->path(), $data)
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('tasks', $data);
    }

    /** @test */
    public function a_task_can_be_incomplete ()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory
            ::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $task = $project->tasks->first();

        $data = [
            'body' => 'Changed',
            'completed' => true,
        ];

        $this->patch($task->path(), $data)
            ->assertRedirect($project->path());

        $data['completed'] = false;

        $this->patch($task->path(), $data)
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('tasks', $data);
    }

    /** @test */
    public function only_owner_of_the_project_can_add_a_task ()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => "Test task"])
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseCount('tasks', 0);
    }

    /** @test */
    public function only_owner_of_the_project_can_update_a_task ()
    {
        $this->signIn();

        $project = ProjectFactory
            ::withTasks(1)
            ->create();

        $data = Task::factory()->raw();

        $this->patch($project->tasks->first()->path(), $data)
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('tasks', $data);
    }

    /** @test */
    public function a_task_requires_the_body ()
    {
        $project = ProjectFactory
            ::ownedBy($this->signIn())
            ->create();

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
