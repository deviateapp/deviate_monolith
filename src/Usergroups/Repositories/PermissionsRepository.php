<?php

namespace Deviate\Usergroups\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Usergroups\Contracts\Repositories\PermissionsRepositoryInterface;
use Deviate\Usergroups\Models\Eloquent\PermissionSection;
use Deviate\Usergroups\Models\Eloquent\Usergroup;
use Deviate\Usergroups\Transformers\PermissionSectionTransformer;
use Deviate\Usergroups\Transformers\UsergroupPermissionTransformer;

class PermissionsRepository extends AbstractRepository implements PermissionsRepositoryInterface
{
    private $permissionSection;
    private $usergroup;
    private $permissionSectionTransformer;
    private $usergroupPermissionTransformer;

    public function __construct(
        PermissionSection $permissionSection,
        Usergroup $usergroup,
        PermissionSectionTransformer $permissionSectionTransformer,
        UsergroupPermissionTransformer $usergroupPermissionTransformer
    ) {
        $this->permissionSection              = $permissionSection;
        $this->usergroup                      = $usergroup;
        $this->permissionSectionTransformer   = $permissionSectionTransformer;
        $this->usergroupPermissionTransformer = $usergroupPermissionTransformer;
    }

    public function sections(bool $includePermissions): array
    {
        $sections = $this->permissionSection->newQuery()->orderBy('name');

        if ($includePermissions) {
            $sections = $sections->with('permissions');
        }

        return $this->permissionSectionTransformer->transformCollection($sections->get());
    }

    public function permissionsForUsergroup(int $usergroupId): array
    {
        $permissions = $this->usergroup->newQuery()->findOrFail($usergroupId)->permissions;

        return $this->usergroupPermissionTransformer->transformCollection($permissions);
    }
}
