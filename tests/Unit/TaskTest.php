<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path ()
    {
        $task = Task::factory()->create();

        $this->assertEquals(
            route('projects.tasks.update', [$task->project->id, $task->id]),
            $task->path()
        );
    }
}
