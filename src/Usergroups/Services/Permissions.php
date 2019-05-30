<?php

namespace Deviate\Usergroups\Services;

use Deviate\Usergroups\Contracts\Repositories\PermissionsRepositoryInterface;
use Deviate\Usergroups\Contracts\Services\PermissionsInterface;

class Permissions implements PermissionsInterface
{
    private $repository;

    public function __construct(PermissionsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function sections(bool $includePermissions): array
    {
        return $this->repository->sections($includePermissions);
    }

    public function listPermissionsInUsergroup(string $usergroupId): array
    {
        return $this->repository->permissionsForUsergroup($usergroupId);
    }
}
