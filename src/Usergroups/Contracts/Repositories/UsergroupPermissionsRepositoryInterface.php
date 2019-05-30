<?php

namespace Deviate\Usergroups\Contracts\Repositories;

use Deviate\Usergroups\Collections\RequestedPermissionsCollection;

interface UsergroupPermissionsRepositoryInterface
{
    public function applyPermissions(int $usergroupId, RequestedPermissionsCollection $permissions): bool;
    public function removeAllPermissions(int $usergroupId): bool;
}
