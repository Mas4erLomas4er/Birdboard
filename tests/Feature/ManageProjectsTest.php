<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use withFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects ()
    {
        $project = ProjectFactory::create();

        $this->assertRoutesRedirect([
            route('projects.index'),
            route('projects.create'),
            route('projects.edit', $project->id),
            $project->path(),
        ], route('login'));

        $this->post('/projects', $project->getAttributes())->assertRedirect('login');
        $this->patch($project->path(), ['notes' => 'Changed'])->assertRedirect('login');
        $this->delete($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project ()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(Response::HTTP_OK);

        $data = Project::factory()->raw(['notes' => null]);

        $response = $this->post('/projects', $data);

        $this->assertDatabaseCount('projects', 1);

        $project = Project::first();

        $response->assertRedirect($project->path());

        $this->get('/projects')->assertSee($data['title']);

        $this->get($project->path())
            ->assertSee($data['title'])
            ->assertSee($data['description']);
    }

    /** @test */
    public function tasks_can_be_included_as_part_a_new_project_creation ()
    {
        $this->signIn();

        $data = Project::factory()->raw(['notes' => null]);

        $data['tasks'] = [
            ['body' => 'Task 1'],
            ['body' => 'Task 2'],
        ];

        $this->post('/projects', $data);

        $this->assertCount(2, Project::first()->tasks);
    }

    /** @test */
    public function a_user_can_delete_a_project ()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory
            ::ownedBy($this->signIn())
            ->create();

        $this->delete($project->path())
            ->assertRedirect(route('projects.index'));

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function a_user_can_update_a_project ()
    {
        $project = ProjectFactory
            ::ownedBy($this->signIn())
            ->create();

        $this->get(route('projects.edit', $project->id))
            ->assertStatus(Response::HTTP_OK);

        $data = Arr::except(Project::factory()->raw(), 'owner_id');

        $this->patch($project->path(), $data)
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $data);
    }

    /** @test */
    public function a_user_can_view_own_project ()
    {
        $project = ProjectFactory
            ::ownedBy($this->signIn())
            ->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_cannot_view_the_projects_of_others ()
    {
        $this->signIn();

        $project = ProjectFactory::create();

        $this->get($project->path())
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function a_user_cannot_update_the_projects_of_others ()
    {
        $this->signIn();

        $project = ProjectFactory::create();

        $this->patch($project->path(), ['notes' => 'Changed'])
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertFalse($project->fresh()->wasChanged());
    }

    /** @test */
    public function a_user_cannot_delete_the_projects_of_others ()
    {
        $this->signIn();

        $project = ProjectFactory::create();

        $this->delete($project->path(), [])
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseCount('projects', 1);
    }

    /** @test */
    public function an_invited_user_cannot_delete_the_project ()
    {
        $user = $this->signIn();

        $project = ProjectFactory::create()->invite($user);

        $this->delete($project->path(), [])
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseCount('projects', 1);
    }

    /** @test */
    public function a_project_requires_a_title ()
    {
        $this->signIn();

        $data = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $data)->assertSessionHasErrors('title', null, 'projects');
    }

    /** @test */
    public function a_project_requires_a_description ()
    {
        $this->signIn();

        $data = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $data)->assertSessionHasErrors('description', null, 'projects');
    }

    /** @test */
    public function a_user_can_view_all_projects_he_have_been_invited_to_on_his_dashboard ()
    {
        $project = ProjectFactory::create()
            ->invite($this->signIn());

        ProjectFactory::create();

        $this->get(route('projects.index'))
            ->assertSee($project->title);
    }
}
