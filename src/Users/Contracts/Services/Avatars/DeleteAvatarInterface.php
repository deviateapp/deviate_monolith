<?php

namespace Deviate\Users\Contracts\Services\Avatars;

interface DeleteAvatarInterface
{
    public function deleteByUserId(int $userId): void;
}
