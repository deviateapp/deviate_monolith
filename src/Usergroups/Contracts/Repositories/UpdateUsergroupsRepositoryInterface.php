<?php

namespace Deviate\Usergroups\Contracts\Repositories;

interface UpdateUsergroupsRepositoryInterface
{
    public function updateUsergroupById(string $id, array $data): bool;
}
