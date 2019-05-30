<?php

namespace Deviate\Users\Tests\Services\Avatars;

use Carbon\Carbon;
use Deviate\Users\Models\Eloquent\Avatar;
use Deviate\Users\Tests\Services\TestCase;

class FetchAvatarTest extends TestCase
{
    /** @test */
    public function it_can_return_an_avatar()
    {
        $avatar = factory(Avatar::class)->create(['user_id' => 1]);

        $response = $this->avatarsClient->fetchAvatar($this->encode(1));

        $response->assertContains([
            'user_id'    => $this->encode(1),
            'path'       => $avatar->path,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found()
    {
        $response = $this->avatarsClient->fetchAvatar($this->encode(999));

        $response->assertException([
            'status' => 404,
        ]);
    }
}
