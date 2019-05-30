<?php

namespace Deviate\Users\Contracts\Services\Avatars;

interface CreateAvatarInterface
{
    public function createDefaultAvatar(int $userId): array;
}
