<?php

namespace Deviate\Usergroups\Contracts\Repositories;

interface PermissionsRepositoryInterface
{
    public function sections(bool $includePermissions): array;
    public function permissionsForUsergroup(int $usergroupId): array;
}
