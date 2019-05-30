<?php

namespace Deviate\Users\Tests\Services\Users;

use Deviate\Users\Tests\Services\TestCase;

class UpdateRememberTokenTest extends TestCase
{
    /** @test */
    public function the_remember_token_can_be_updated()
    {
        $response = $this->updatesUsersClient->updateRememberToken($this->encode(1), 'test-remember-token');

        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => 1,
            'remember_token' => 'test-remember-token',
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found()
    {
        $response = $this->updatesUsersClient->updateRememberToken($this->encode(999), 'test-remember-token');

        $response->assertException([
            'status' => 404,
        ]);
    }
}
