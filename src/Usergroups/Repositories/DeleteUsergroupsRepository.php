<?php

namespace Deviate\Usergroups\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Usergroups\Contracts\Repositories\DeleteUsergroupsRepositoryInterface;
use Deviate\Usergroups\Models\Eloquent\Usergroup;

class DeleteUsergroupsRepository extends AbstractRepository implements DeleteUsergroupsRepositoryInterface
{
    private $usergroup;

    public function __construct(Usergroup $usergroup)
    {
        $this->usergroup = $usergroup;
    }

    public function deleteUsergroupById(int $usergroupId): bool
    {
        return (bool) $this->usergroup->newQuery()->findOrFail($usergroupId)->delete();
    }

    public function deleteUsergroupByOrganisationId(int $organisationId): bool
    {
        return (bool) $this->usergroup->newQuery()->where('organisation_id', $organisationId)->delete();
    }
}
