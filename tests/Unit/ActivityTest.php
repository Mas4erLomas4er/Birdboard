<?php

namespace Tests\Unit;

use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user ()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $user = $project->activities()->first()->user;

        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals($project->owner->id, $user->id);
    }
}
