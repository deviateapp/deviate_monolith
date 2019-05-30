<?php

namespace Deviate\Usergroups\Contracts\Services;

interface DeleteUsergroupInterface
{
    public function deleteById(string $id): void;
}
