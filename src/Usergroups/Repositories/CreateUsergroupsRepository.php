<?php

namespace Deviate\Usergroups\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Usergroups\Contracts\Repositories\CreateUsergroupsRepositoryInterface;
use Deviate\Usergroups\Models\Eloquent\Usergroup;

class CreateUsergroupsRepository extends AbstractRepository implements CreateUsergroupsRepositoryInterface
{
    private $usergroup;

    public function __construct(Usergroup $usergroup)
    {
        $this->usergroup   = $usergroup;
    }

    public function createUsergroup(array $data): string
    {
        /** @var Usergroup $usergroup */
        $usergroup = $this->usergroup->newQuery()->create([
            'organisation_id' => $data['organisation_id'],
            'name'            => $data['name'],
            'description'     => $data['description'],
            'is_supergroup'   => $data['is_supergroup'] ?? false,
        ]);

        return $this->encode($usergroup->id);
    }
}
