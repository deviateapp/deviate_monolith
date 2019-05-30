<?php

declare(strict_types=1);

namespace Deviate\Users\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Illuminate\Http\UploadedFile;

class AvatarsClient extends AbstractClient implements AvatarsClientInterface
{
    public function addAvatar(string $userId, UploadedFile $file): ApiResponseInterface
    {
        return $this->call('users.avatars.upload', [
            'id'      => $userId,
            'content' => base64_encode(file_get_contents($file->path())),
        ]);
    }

    public function addDefaultAvatar(string $userId): ApiResponseInterface
    {
        return $this->call('users.avatars.create_default', [
            'id' => $userId,
        ]);
    }

    public function deleteAvatar(string $userId): ApiResponseInterface
    {
        return $this->call('users.avatars.delete', [
            'id' => $userId,
        ]);
    }

    public function fetchAvatar(string $userId): ApiResponseInterface
    {
        return $this->call('users.avatars.fetch', [
            'id' => $userId,
        ]);
    }
}
