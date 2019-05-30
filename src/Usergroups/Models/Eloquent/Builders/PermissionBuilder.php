<?php

namespace Deviate\Usergroups\Models\Eloquent\Builders;

use Deviate\Shared\Traits\ConvertsHashIds;
use Deviate\Shared\Traits\Models\StandardBuilderMethods;
use Deviate\Usergroups\Collections\RequestedPermissionsCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermissionBuilder extends Builder
{
    use ConvertsHashIds,
        StandardBuilderMethods;

    public function forRequestedPermissions(RequestedPermissionsCollection $permissions)
    {
        return $this->whereIn('permission_key', $permissions->permissionKeys())->get();
    }

    protected function throwNotFoundException(ModelNotFoundException $exception)
    {
        throw $exception;
    }
}
