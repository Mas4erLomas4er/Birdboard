<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProjectsTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects ()
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task 123'])->assertRedirect('login');
    }

    /** @test */
    public function a_task_can_be_created ()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $this->post($project->path() . '/tasks', ['body' => "Test task"]);

        $this->get($project->path())
            ->assertSee("Test task");
    }

    /** @test */
    public function a_task_can_be_updated ()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $task = $project->addTask('Test task 321');

        $data = Task::factory()->raw(['project_id' => $project->id, 'completed' => true]);

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

        $project = Project::factory()->create();
        $task = $project->addTask('Test task 123');

        $data = Task::factory()->raw();

        $this->patch($task->path(), $data)
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseMissing('tasks', $data);
    }

    /** @test */
    public function a_task_requires_the_body ()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
