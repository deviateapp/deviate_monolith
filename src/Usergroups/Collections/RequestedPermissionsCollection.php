<?php

namespace Deviate\Usergroups\Collections;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class RequestedPermissionsCollection extends Collection
{
    public function mustOwnResource(): RequestedPermissionsCollection
    {
        return $this->filter(function ($permission) {
            return $permission['must_own_resource'] ?? false;
        });
    }

    public function mustNotOwnResource(): RequestedPermissionsCollection
    {
        return $this->filter(function ($permission) {
            return !$permission['must_own_resource'] ?? true;
        });
    }

    public function permissionKeys()
    {
        return $this->pluck('key')->toArray();
    }

    public function extractPivotData(Collection $ownable)
    {
        return $this->values()->map(function ($permission) use ($ownable) {
            return [
                'must_own_resource' => $ownable->contains($permission['key'])
                    ? Arr::get($permission, 'must_own_resource', false)
                    : false,
            ];
        })->toArray();
    }
}
