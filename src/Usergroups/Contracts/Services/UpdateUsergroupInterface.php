<?php

namespace Deviate\Usergroups\Contracts\Services;

interface UpdateUsergroupInterface
{
    public function updateByUsergroupId(string $id, array $data): array;
    public function applyPermissions(string $id, array $permissions): void;
}
