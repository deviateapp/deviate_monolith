<?php

namespace Deviate\Users\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Illuminate\Http\UploadedFile;

interface AvatarsClientInterface
{
    public function addAvatar(string $userId, UploadedFile $file): ApiResponseInterface;
    public function addDefaultAvatar(string $userId): ApiResponseInterface;
    public function fetchAvatar(string $userId): ApiResponseInterface;
    public function deleteAvatar(string $userId): ApiResponseInterface;
}
