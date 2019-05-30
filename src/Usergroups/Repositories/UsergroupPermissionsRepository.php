<?php

namespace Deviate\Usergroups\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Usergroups\Collections\RequestedPermissionsCollection;
use Deviate\Usergroups\Contracts\Repositories\UsergroupPermissionsRepositoryInterface;
use Deviate\Usergroups\Models\Eloquent\Permission;
use Deviate\Usergroups\Models\Eloquent\Usergroup;

class UsergroupPermissionsRepository extends AbstractRepository implements UsergroupPermissionsRepositoryInterface
{
    private $usergroup;
    private $permission;

    public function __construct(Usergroup $usergroup, Permission $permission)
    {
        $this->usergroup  = $usergroup;
        $this->permission = $permission;
    }

    public function applyPermissions(string $usergroupId, RequestedPermissionsCollection $permissions): bool
    {
        /** @var \Illuminate\Support\Collection $permissionRecords */
        $permissionRecords = $this->permission->newQuery()->forRequestedPermissions($permissions);
        $ownableRecords    = $permissionRecords->where('is_ownable')->pluck('permission_key');

        /** @var Usergroup $usergroup */
        $usergroup = $this->usergroup->newQuery()->findOrFail($usergroupId);
        $usergroup->permissions()->saveMany($permissionRecords, $permissions->extractPivotData($ownableRecords));

        return true;
    }

    public function removeAllPermissions(string $usergroupId): bool
    {
        /** @var Usergroup $usergroup */
        $usergroup = $this->usergroup->newQuery()->findOrFail($usergroupId);

        return $usergroup->permissions()->delete();
    }
}
