<?php

namespace Deviate\Users\Contracts\Repositories;

interface UpdateUsersRepositoryInterface
{
    public function updateUserById(string $id, array $details): bool;
    public function updateActivationById(string $id, bool $isActive): bool;
}
