<?php

namespace Deviate\Users\Contracts\Services\Avatars;

interface CreateAvatarInterface
{
    public function createDefaultAvatar(string $userId): array;
}
