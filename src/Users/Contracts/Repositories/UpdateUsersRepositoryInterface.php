<?php

namespace Deviate\Users\Contracts\Repositories;

interface UpdateUsersRepositoryInterface
{
    public function updateUserById(int $id, array $details): bool;
    public function updateActivationById(int $id, bool $isActive): bool;
}
