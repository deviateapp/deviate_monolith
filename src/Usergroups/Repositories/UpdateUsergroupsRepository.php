<?php

namespace Deviate\Usergroups\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Usergroups\Contracts\Repositories\UpdateUsergroupsRepositoryInterface;
use Deviate\Usergroups\Models\Eloquent\Usergroup;

class UpdateUsergroupsRepository extends AbstractRepository implements UpdateUsergroupsRepositoryInterface
{
    private $usergroup;

    public function __construct(Usergroup $usergroup)
    {
        $this->usergroup = $usergroup;
    }

    public function updateUsergroupById(string $id, array $data): bool
    {
        $usergroup = $this->usergroup->newQuery()->findOrFail($id)->toArray();
        $data      = array_merge($usergroup, $data);

        return (bool) $this->usergroup->newQuery()->findOrFail($id)->update([
            'name'          => $data['name'],
            'description'   => $data['description'],
            'is_supergroup' => (bool) $data['is_supergroup'],
        ]);
    }
}
