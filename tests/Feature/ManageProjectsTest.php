<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use withFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects ()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->getAttributes())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project ()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(Response::HTTP_OK);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
        ];

        $response = $this->post('/projects', $attributes);

        $this->assertDatabaseHas('projects', $attributes);

        $response->assertRedirect(Project::first()->path());

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_view_own_project ()
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_cannot_view_the_projects_of_others ()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function a_project_requires_a_title ()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description ()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
