<?php

namespace Deviate\Users\Tests\Services\Users;

use Deviate\Users\Models\Eloquent\User;
use Deviate\Users\Tests\Services\TestCase;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordTest extends TestCase
{
    /** @test */
    public function it_can_update_a_users_password()
    {
        $response = $this->updatesUsersClient->updatePassword($this->encode(1), 'updatedpassword');

        $response->assertSuccessful();

        $this->assertTrue(Hash::check('updatedpassword', User::find(1)->password));
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found()
    {
        $response = $this->updatesUsersClient->updatePassword($this->encode(999), 'updatedpassword');

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_password_is_invalid()
    {
        $response = $this->updatesUsersClient->updatePassword($this->encode(1), 'a');

        $response->assertException([
            'status' => 422,
            'meta' => ['password'],
        ]);
    }
}
