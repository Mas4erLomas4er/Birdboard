<?php

namespace Tests\Unit;

use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects ()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_accessible_projects ()
    {
        $user = User::factory()->create();

        ProjectFactory::ownedBy($user)->create();

        $anotherUser = User::factory()->create();

        ProjectFactory::ownedBy($anotherUser)
            ->create()
            ->invite($user);

        ProjectFactory::create()->invite($anotherUser);

        $this->assertCount(2, $user->allProjects());
    }
}
