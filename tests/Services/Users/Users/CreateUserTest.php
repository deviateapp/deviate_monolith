<?php

namespace Deviate\Users\Tests\Services\Users;

use Deviate\Users\Models\Eloquent\User;
use Deviate\Users\Tests\Services\TestCase;
use Illuminate\Support\Facades\Hash;

class CreateUserTest extends TestCase
{
    /** @test */
    public function test_a_new_user_can_be_created()
    {
        $response = $this->createsUsersClient->createUser([
            'organisation_id' => $this->encode(1),
            'forename'        => 'Caitlin',
            'surname'         => 'Cross',
            'email'           => 'caitlin@deviate.test',
            'password'        => 'testpassword',
        ]);

        $this->assertDatabaseHas('users', [
            'organisation_id' => 1,
            'forename'        => 'Caitlin',
            'surname'         => 'Cross',
            'email'           => 'caitlin@deviate.test',
        ]);

        $response->assertContains([
            'organisation_id' => $this->encode(1),
            'forename'        => 'Caitlin',
            'surname'         => 'Cross',
            'email'           => 'caitlin@deviate.test',
        ]);

        $this->assertTrue(Hash::check('testpassword', User::find($this->decode($response->get('id')))->password));
    }

    /** @test */
    public function test_it_returns_an_error_if_the_data_is_invalid()
    {
        $response = $this->createsUsersClient->createUser([]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['organisation_id', 'forename', 'surname', 'email', 'password'],
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_organisation_doesnt_exist()
    {
        $response = $this->createsUsersClient->createUser([
            'organisation_id' => $this->encode(999),
            'forename'        => 'Caitlin',
            'surname'         => 'Cross',
            'email'           => 'caitlin@deviate.test',
            'password'        => 'testpassword',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['organisation_id'],
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_email_has_already_been_registered_within_the_organisation()
    {
        $response = $this->createsUsersClient->createUser([
            'organisation_id' => $this->encode(1),
            'forename'        => 'Caitlin',
            'surname'         => 'Cross',
            'email'           => 'brody@deviate.test',
            'password'        => 'testpassword',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['email'],
        ]);
    }
}
