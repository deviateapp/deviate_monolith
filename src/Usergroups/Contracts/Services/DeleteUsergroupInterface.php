<?php

namespace Deviate\Usergroups\Contracts\Services;

interface DeleteUsergroupInterface
{
    public function deleteById(int $id): void;
}
