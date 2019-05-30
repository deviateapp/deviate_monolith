<?php

namespace Deviate\Users\Contracts\Repositories;

interface FetchAvatarsRepositoryInterface
{
    public function fetchAvatarByUserId(string $userId): array;
    public function hasAvatar(string $userId): bool;
}
