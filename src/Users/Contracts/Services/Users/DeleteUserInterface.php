<?php

namespace Deviate\Users\Contracts\Services\Users;

interface DeleteUserInterface
{
    public function deleteUser(int $userId): void;
}
