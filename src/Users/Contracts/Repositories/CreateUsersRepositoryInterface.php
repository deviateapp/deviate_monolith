<?php

namespace Deviate\Users\Contracts\Repositories;

interface CreateUsersRepositoryInterface
{
    public function createUser(array $data): string;
}
