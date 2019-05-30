<?php

namespace Deviate\Users\Contracts\Repositories;

interface FetchAvatarsRepositoryInterface
{
    public function fetchAvatarByUserId(int $userId): array;
    public function hasAvatar(int $userId): bool;
}
