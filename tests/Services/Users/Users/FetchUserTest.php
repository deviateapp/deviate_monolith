<?php

namespace Deviate\Users\Tests\Services\Users;

use Carbon\Carbon;
use Deviate\Users\Models\Eloquent\User;
use Deviate\Users\Tests\Services\TestCase;

class FetchUserTest extends TestCase
{
    /** @test */
    public function it_can_return_a_user_by_their_id()
    {
        $response = $this->fetchesUsersClient->fetchUserById(1);

        $response->assertContains([
            'id'              => 1,
            'organisation_id' => 1,
            'forename'        => 'Brody',
            'surname'         => 'Cross',
            'email'           => 'brody@deviate.test',
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found()
    {
        $response = $this->fetchesUsersClient->fetchUserById(999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_can_fetch_a_user_by_their_remember_token()
    {
        $token = User::find(1)->remember_token;

        $response = $this->fetchesUsersClient->fetchUserByRememberToken(1, $token);

        $response->assertContains([
            'id' => 1,
        ]);
    }
}
