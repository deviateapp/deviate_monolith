<?php

namespace Deviate\Usergroups\Contracts\Services;

interface FetchUsergroupInterface
{
    public function fetchById(int $id): array;
}
