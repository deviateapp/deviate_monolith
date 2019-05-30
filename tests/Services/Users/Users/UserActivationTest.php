<?php

namespace Deviate\Users\Tests\Services\Users;

use Carbon\Carbon;
use Deviate\Users\Models\Eloquent\User;
use Deviate\Users\Tests\Services\TestCase;

class UserActivationTest extends TestCase
{
    /** @test */
    public function an_active_user_can_be_disabled()
    {
        $response = $this->updatesUsersClient->deactivateUser(1);

        $response->assertContains([
            'disabled_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $this->assertSoftDeleted('users', [
            'id' => 1,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found()
    {
        $response = $this->updatesUsersClient->deactivateUser(999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_can_enable_a_user()
    {
        User::find(1)->update(['deleted_at' => Carbon::now()]);

        $response = $this->updatesUsersClient->reactivateUser(1);

        $this->assertDatabaseHas('users', [
            'id'         => 1,
            'deleted_at' => null,
        ]);

        $response->assertContains([
            'disabled_at' => null,
        ]);
    }
}
