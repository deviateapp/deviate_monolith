<?php

namespace Deviate\Users\Tests\Services\Avatars;

use Deviate\Users\Models\Eloquent\Avatar;
use Deviate\Users\Tests\Services\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadAvatarTest extends TestCase
{
    /** @test */
    public function a_new_avatar_can_be_uploaded()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->avatarsClient->addAvatar($this->encode(1), $file);

        $response->assertContains([
            'user_id' => $this->encode(1),
        ]);

        $this->assertDatabaseHas('avatars', [
            'user_id' => 1,
            'path'    => $response->get('path'),
        ]);

        Storage::disk('avatars')->assertExists($response->get('path'));
    }

    /** @test */
    public function it_deletes_the_previous_avatar_if_one_exists()
    {
        $existing  = factory(Avatar::class)->create(['user_id' => 1]);
        $newAvatar = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->avatarsClient->addAvatar($this->encode(1), $newAvatar);

        $response->assertSuccessful();

        $this->assertSoftDeleted('avatars', [
            'id' => $existing->id,
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_the_uploaded_file_is_not_an_image()
    {
        $file = UploadedFile::fake()->create('invalid-file.txt', 10);

        $response = $this->avatarsClient->addAvatar($this->encode(1), $file);

        $response->assertException([
            'status' => 422,
            'meta'   => ['avatar'],
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_the_avatar_is_larger_than_1000px_by_1000px()
    {
        $file = UploadedFile::fake()->image('invalid-file.txt', 1001, 1001);

        $response = $this->avatarsClient->addAvatar($this->encode(1), $file);

        $response->assertException([
            'status' => 422,
            'meta'   => ['avatar'],
        ]);
    }
}
