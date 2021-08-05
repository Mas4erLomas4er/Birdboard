<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertCount;

class ProjectTest extends TestCase
{
    use withFaker, RefreshDatabase;

    /** @test */
    public function it_has_a_path ()
    {
        $project = Project::factory()->create();

        $this->assertEquals(route('projects.show', $project->id), $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner ()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function it_can_add_a_task ()
    {
        $project = Project::factory()->create();

        $task = $project->addTask('Test task 123');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }

    /** @test */
    public function in_can_invite_a_user ()
    {
        $project = ProjectFactory::create();

        $project->invite($user = User::factory()->create());

        $this->assertTrue($project->members->contains($user));
    }
}
