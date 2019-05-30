<?php

namespace Deviate\Usergroups\Contracts\Services;

interface FetchUsergroupInterface
{
    public function fetchById(string $id): array;
}
