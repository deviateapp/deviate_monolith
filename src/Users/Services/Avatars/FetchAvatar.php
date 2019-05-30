<?php

namespace Deviate\Users\Services\Avatars;

use Deviate\Users\Contracts\Repositories\FetchAvatarsRepositoryInterface;
use Deviate\Users\Contracts\Services\Avatars\FetchAvatarInterface;

class FetchAvatar implements FetchAvatarInterface
{
    /** @var FetchAvatarsRepositoryInterface */
    private $fetchesAvatars;

    public function __construct(FetchAvatarsRepositoryInterface $fetchesAvatars)
    {
        $this->fetchesAvatars = $fetchesAvatars;
    }

    public function fetchAvatarByUserId(string $userId): array
    {
        return $this->fetchesAvatars->fetchAvatarByUserId($userId);
    }
}
