<?php

namespace Deviate\Usergroups\Contracts\Services;

interface PermissionsInterface
{
    public function sections(bool $includePermissions): array;
    public function listPermissionsInUsergroup(int $usergroupId): array;
}
