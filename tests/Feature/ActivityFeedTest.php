<?php

namespace Tests\Feature;

use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project_records_activity ()
    {
        $project = ProjectFactory::create();

        $activity = $project->activities->last();

        $this->assertNotNull($activity);

        $this->assertEquals('created_project', $activity->description);

        $this->assertNull($activity->changes);
    }

    /** @test */
    public function updating_a_project_records_activity ()
    {
        $project = ProjectFactory::create();
        $original_title = $project->title;

        $project->update(['title' => 'Changed']);

        $activity = $project->activities->last();

        $this->assertNotNull($activity);

        $this->assertEquals('updated_project', $activity->description);

        $expected = [
            'before' => ['title' => $original_title],
            'after' => ['title' => 'Changed'],
        ];

        $this->assertEquals($expected, $activity->changes);
    }

    /** @test */
    public function creating_a_task_records_a_project_activity ()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $activity = $project->activities->last();

        $this->assertNotNull($activity);
        $this->assertEquals('created_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);
        $this->assertEquals($project->tasks()->first()->body, $activity->subject->body);
    }

    /** @test */
    public function completing_a_task_records_a_project_activity ()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $task = $project->tasks()->first();

        $task->complete();

        $activity = $project->activities->last();

        $this->assertNotNull($activity);
        $this->assertEquals('completed_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);
        $this->assertEquals($task->body, $activity->subject->body);
    }

    /** @test */
    public function incompleting_a_task_records_a_project_activity ()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $task = $project->tasks()->first();

        $task->complete();
        $task->incomplete();

        $activity = $project->activities->last();

        $this->assertNotNull($activity);
        $this->assertEquals('uncompleted_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);
        $this->assertEquals($task->body, $activity->subject->body);
    }

    /** @test */
    public function deleting_a_task_records_a_project_activity ()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks()->first()->delete();

        $activity = $project->activities->last();

        $this->assertNotNull($activity);

        $this->assertEquals('deleted_task', $activity->description);
    }
}
