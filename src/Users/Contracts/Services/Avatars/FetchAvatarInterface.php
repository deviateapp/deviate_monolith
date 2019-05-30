<?php

namespace Deviate\Users\Contracts\Services\Avatars;

interface FetchAvatarInterface
{
    public function fetchAvatarByUserId(string $userId): array;
}
