<?php

namespace Deviate\Users\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Users\Contracts\Repositories\CreateAvatarsRepositoryInterface;
use Deviate\Users\Contracts\Repositories\DeleteAvatarsRepositoryInterface;
use Deviate\Users\Contracts\Repositories\FetchUsersRepositoryInterface;
use Deviate\Users\Models\Eloquent\Avatar;

class CreateAvatarsRepository extends AbstractRepository implements CreateAvatarsRepositoryInterface
{
    /** @var FetchUsersRepositoryInterface */
    private $fetchesUsers;

    /** @var DeleteAvatarsRepositoryInterface */
    private $deletesAvatars;

    /** @var Avatar */
    private $avatar;

    public function __construct(
        FetchUsersRepositoryInterface $fetchesUsers,
        DeleteAvatarsRepositoryInterface $deletesAvatars,
        Avatar $avatar
    ) {
        $this->fetchesUsers   = $fetchesUsers;
        $this->deletesAvatars = $deletesAvatars;
        $this->avatar         = $avatar;
    }

    public function recordNewAvatar(int $userId, string $path): bool
    {
        $user = $this->fetchesUsers->fetchUserById($userId);

        $this->deletesAvatars->deleteAvatarByUserId($userId);

        return (bool) $this->avatar->newQuery()->create([
            'organisation_id' => $user['organisation_id'],
            'user_id'         => $userId,
            'path'            => $path,
        ]);
    }
}
