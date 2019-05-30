<?php

namespace Deviate\Usergroups\Contracts\Repositories;

interface CreateUsergroupsRepositoryInterface
{
    public function createUsergroup(array $data): int;
}
