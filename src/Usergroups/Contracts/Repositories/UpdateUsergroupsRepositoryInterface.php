<?php

namespace Deviate\Usergroups\Contracts\Repositories;

interface UpdateUsergroupsRepositoryInterface
{
    public function updateUsergroupById(int $id, array $data): bool;
}
