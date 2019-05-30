<?php

namespace Deviate\Users\Contracts\Repositories;

interface CreateAvatarsRepositoryInterface
{
    public function recordNewAvatar(int $userId, string $path): bool;
}
