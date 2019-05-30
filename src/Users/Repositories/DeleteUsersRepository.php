<?php

namespace Deviate\Users\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Users\Contracts\Repositories\DeleteUsersRepositoryInterface;
use Deviate\Users\Models\Eloquent\User;

class DeleteUsersRepository extends AbstractRepository implements DeleteUsersRepositoryInterface
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function deleteUserById(int $id): bool
    {
        return (bool) $this->user->newQuery()->withTrashed()->findOrFail($id)->forceDelete();
    }

    public function deleteUsersByOrganisationId(int $id): bool
    {
        return (bool) $this->user->newQuery()->withTrashed()->where([
            'organisation_id' => $id,
        ])->forceDelete();
    }
}
