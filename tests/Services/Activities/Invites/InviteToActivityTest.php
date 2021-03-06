<?php

namespace Deviate\Activities\Tests\Services\Invites;

use Deviate\Activities\Tests\Services\TestCase;
use Illuminate\Support\Facades\DB;

class InviteToActivityTest extends TestCase
{
    /** @test */
    public function it_can_invite_a_user_to_an_activity()
    {
        $response = $this->invitationsClient->invite(1, 1);

        $response->assertSuccessful();

        $this->assertDatabaseHas('activity_user', [
            'activity_id' => 1,
            'user_id'     => 1,
            'status'      => 'invited',
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_to_invite_cant_be_found()
    {
        $response = $this->invitationsClient->invite(999, 1);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_activity_to_invite_to_cant_be_found()
    {
        $response = $this->invitationsClient->invite(1, 999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_is_already_invited_to_an_activity()
    {
        DB::table('activity_user')->insert([
            'activity_id' => 1,
            'user_id'     => 1,
            'status'      => 'invited',
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s'),
        ]);

        $response = $this->invitationsClient->invite(1, 1);

        $response->assertException([
            'status' => 400,
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_trying_to_invite_an_already_booked_user()
    {
        DB::table('activity_user')->insert([
            'activity_id' => 1,
            'user_id'     => 1,
            'status'      => 'booked',
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s'),
        ]);

        $response = $this->invitationsClient->invite(1, 1);

        $response->assertException([
            'status' => 400,
        ]);
    }
}
