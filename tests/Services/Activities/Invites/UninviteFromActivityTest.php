<?php

namespace Deviate\Activities\Tests\Services\Invites;

use Deviate\Activities\Models\Eloquent\Invitation;
use Deviate\Activities\Tests\Services\TestCase;

class UninviteFromActivityTest extends TestCase
{
    /** @test */
    public function it_can_uninvite_an_invited_user_from_an_activity()
    {
        Invitation::create([
            'activity_id' => 1,
            'user_id'     => 1,
        ]);

        $response = $this->invitationsClient->uninvite(1, 1);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('activity_user', [
            'activity_id' => 1,
            'user_id'     => 1,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_to_invite_cant_be_found()
    {
        $response = $this->invitationsClient->uninvite(999, 1);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_activity_to_invite_to_cant_be_found()
    {
        $response = $this->invitationsClient->uninvite(1, 999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_is_not_invited_to_an_activity()
    {
        $response = $this->invitationsClient->uninvite(1, 1);

        $response->assertException([
            'status' => 400,
        ]);
    }
}
