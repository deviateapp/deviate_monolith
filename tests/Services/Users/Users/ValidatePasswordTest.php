<?php

namespace Deviate\Users\Tests\Services\Users;

use Deviate\Users\Tests\Services\TestCase;

class ValidatePasswordTest extends TestCase
{
    /** @test */
    public function it_can_validate_a_users_password()
    {
        $response = $this->authenticatesUsersClient->validatePassword(1, 'testpassword');

        $response->assertContains([
            'valid' => true,
        ]);
    }

    /** @test */
    public function it_returns_false_if_the_password_is_wrong()
    {
        $response = $this->authenticatesUsersClient->validatePassword(1, 'wrongpassword');

        $response->assertContains([
            'valid' => false,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found()
    {
        $response = $this->authenticatesUsersClient->validatePassword(999, 'password');

        $response->assertException([
            'status' => 404,
        ]);
    }
}
