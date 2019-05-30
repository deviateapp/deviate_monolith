<?php

namespace Deviate\Users\Contracts\Repositories;

interface CreateAvatarsRepositoryInterface
{
    public function recordNewAvatar(string $userId, string $path): bool;
}
