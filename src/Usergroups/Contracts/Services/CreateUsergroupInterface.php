<?php

namespace Deviate\Usergroups\Contracts\Services;

interface CreateUsergroupInterface
{
    public function createSingleUsergroup(array $data): array;
}
