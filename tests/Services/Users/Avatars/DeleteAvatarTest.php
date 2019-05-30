<?php

namespace Deviate\Users\Tests\Services\Avatars;

use Deviate\Users\Models\Eloquent\Avatar;
use Deviate\Users\Tests\Services\TestCase;

class DeleteAvatarTest extends TestCase
{
    /** @test */
    public function it_can_delete_an_avatar()
    {
        $avatar = factory(Avatar::class)->create(['user_id' => 1]);

        $response = $this->avatarsClient->deleteAvatar($this->encode(1));

        $response->assertSuccessful();

        $this->assertSoftDeleted('avatars', [
            'user_id' => 1,
            'path'    => $avatar->path,
        ]);
    }

    /** @test */
    public function it_creates_a_default_avatar_if_deleting_the_last_one()
    {
        factory(Avatar::class)->create(['user_id' => 1]);

        $response = $this->avatarsClient->deleteAvatar($this->encode(1));

        $response->assertSuccessful();

        $this->assertDatabaseHas('avatars', [
            'user_id'    => 1,
            'deleted_at' => null,
        ]);
    }
}
