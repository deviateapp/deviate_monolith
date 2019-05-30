<?php

namespace Deviate\Users\Tests\Services\Avatars;

use Deviate\Users\Models\Eloquent\Avatar;
use Deviate\Users\Tests\Services\TestCase;
use Illuminate\Support\Facades\Storage;

class CreateDefaultAvatarTest extends TestCase
{
    /** @test */
    public function it_can_create_a_default_avatar_for_a_user()
    {
        $response = $this->avatarsClient->addDefaultAvatar(1);

        Storage::disk('avatars')->assertExists($response->get('path'));

        $this->assertDatabaseHas('avatars', [
            'user_id' => 1,
            'path'    => $response->get('path'),
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found()
    {
        $response = $this->avatarsClient->addDefaultAvatar(999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_deletes_the_previous_avatar_if_one_exists()
    {
        $existing = factory(Avatar::class)->create(['user_id' => 1]);

        $response = $this->avatarsClient->addDefaultAvatar(1);

        $response->assertSuccessful();

        $this->assertSoftDeleted('avatars', [
            'id' => $existing->id,
        ]);
    }
}
