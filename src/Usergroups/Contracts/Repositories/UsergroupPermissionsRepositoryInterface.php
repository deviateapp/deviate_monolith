<?php

namespace Deviate\Usergroups\Contracts\Repositories;

use Deviate\Usergroups\Collections\RequestedPermissionsCollection;

interface UsergroupPermissionsRepositoryInterface
{
    public function applyPermissions(string $usergroupId, RequestedPermissionsCollection $permissions): bool;
    public function removeAllPermissions(string $usergroupId): bool;
}
