<?php

namespace Deviate\Users\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Users\Contracts\Repositories\DeleteAvatarsRepositoryInterface;
use Deviate\Users\Models\Eloquent\Avatar;

class DeleteAvatarsRepository extends AbstractRepository implements DeleteAvatarsRepositoryInterface
{
    /** @var Avatar */
    private $avatar;

    public function __construct(Avatar $avatar)
    {
        $this->avatar = $avatar;
    }

    public function deleteAvatarByUserId(int $userId): bool
    {
        return (bool) $this->avatar->newQuery()->where('user_id', $userId)->delete();
    }

    public function deleteAvatarsByOrganisationId(int $organisationId): bool
    {
        return (bool) $this->avatar->newQuery()->where('organisation_id', $organisationId)->forceDelete();
    }
}
