<?php

namespace Deviate\Users\Contracts\Services\Users;

interface CreateUserInterface
{
    public function createSingleUser(array $data): array;
}
