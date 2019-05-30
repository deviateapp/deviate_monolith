<?php

namespace Deviate\Users\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Illuminate\Http\UploadedFile;

interface AvatarsClientInterface
{
    public function addAvatar(int $userId, UploadedFile $file): ApiResponseInterface;
    public function addDefaultAvatar(int $userId): ApiResponseInterface;
    public function fetchAvatar(int $userId): ApiResponseInterface;
    public function deleteAvatar(int $userId): ApiResponseInterface;
}
