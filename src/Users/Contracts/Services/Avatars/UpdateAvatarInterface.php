<?php

namespace Deviate\Users\Contracts\Services\Avatars;

use Illuminate\Http\UploadedFile;

interface UpdateAvatarInterface
{
    public function uploadNewAvatar(string $userId, UploadedFile $content): array;
}
