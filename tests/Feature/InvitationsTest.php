<?php

namespace Tests\Feature;

use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_invited_user_cannot_invite_to_the_project ()
    {
        $project = ProjectFactory::create()->invite($this->signIn());

        $this->post($project->path() . '/invitations', ['email' => 'some@email.test'])
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertCount(1, $project->members);
    }

    /** @test */
    public function a_user_cannot_invite_to_the_projects_of_others ()
    {
        $project = ProjectFactory::create();

        $this->signIn();

        $this->post($project->path() . '/invitations', ['email' => 'some@email.test'])
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertCount(0, $project->members);
    }

    /** @test */
    public function a_project_owner_can_invite_a_user ()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $user = User::factory()->create();

        $this->post($project->path() . '/invitations', ['email' => $user->email])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($user));
    }

    /** @test */
    public function the_email_must_be_associated_with_a_user ()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->post($project->path() . '/invitations', ['email' => 'not@user.test'])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have a Birdboard account',
            ], null, 'invitations');
    }

    /** @test */
    public function an_invited_user_can_update_a_project ()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);

        $this->post(route('projects.tasks.store', $project), $data = ['body' => 'Test task']);

        $this->assertDatabaseHas('tasks', $data);
    }
}
