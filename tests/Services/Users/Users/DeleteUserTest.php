<?php

namespace Deviate\Users\Tests\Services\Users;

use Carbon\Carbon;
use Deviate\Users\Models\Eloquent\User;
use Deviate\Users\Tests\Services\TestCase;

class DeleteUserTest extends TestCase
{
    /** @test */
    public function a_disabled_user_can_be_deleted()
    {
        User::find(1)->update(['deleted_at' => Carbon::now()]);

        $response = $this->deletesUsersClient->deleteUser(1);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('users', [
            'id' => 1,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_doesnt_exist()
    {
        $response = $this->deletesUsersClient->deleteUser(999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_is_not_disabled_before_trying_to_delete()
    {
        $response = $this->deletesUsersClient->deleteUser(1);

        $response->assertException([
            'status' => 409,
            'title' => 'User not disabled',
            'description' => 'The user must be disabled before deleting.',
        ]);
    }
}
