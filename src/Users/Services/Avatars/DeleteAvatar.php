<?php

namespace Deviate\Users\Services\Avatars;

use Deviate\Users\Contracts\Repositories\DeleteAvatarsRepositoryInterface;
use Deviate\Users\Contracts\Repositories\FetchAvatarsRepositoryInterface;
use Deviate\Users\Contracts\Services\Avatars\CreateAvatarInterface;
use Deviate\Users\Contracts\Services\Avatars\DeleteAvatarInterface;

class DeleteAvatar implements DeleteAvatarInterface
{
    /** @var DeleteAvatarsRepositoryInterface */
    private $deletesAvatars;

    /** @var FetchAvatarsRepositoryInterface */
    private $fetchesAvatars;

    /** @var CreateAvatarInterface */
    private $createAvatar;

    public function __construct(
        DeleteAvatarsRepositoryInterface $deletesAvatars,
        FetchAvatarsRepositoryInterface $fetchesAvatars,
        CreateAvatarInterface $createAvatar
    ) {
        $this->deletesAvatars = $deletesAvatars;
        $this->fetchesAvatars = $fetchesAvatars;
        $this->createAvatar   = $createAvatar;
    }

    public function deleteByUserId(string $userId): void
    {
        $this->deletesAvatars->deleteAvatarByUserId($userId);

        if (!$this->fetchesAvatars->hasAvatar($userId)) {
            $this->createAvatar->createDefaultAvatar($userId);
        }
    }
}
