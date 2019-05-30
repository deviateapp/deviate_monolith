<?php

namespace Deviate\Usergroups\Contracts\Services;

interface UpdateUsergroupInterface
{
    public function updateByUsergroupId(int $id, array $data): array;
    public function applyPermissions(int $id, array $permissions): void;
}
