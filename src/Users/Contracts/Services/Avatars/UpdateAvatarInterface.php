<?php

namespace Deviate\Users\Contracts\Services\Avatars;

use Illuminate\Http\UploadedFile;

interface UpdateAvatarInterface
{
    public function uploadNewAvatar(int $userId, UploadedFile $content): array;
}
