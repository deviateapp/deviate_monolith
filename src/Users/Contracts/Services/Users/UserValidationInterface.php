<?php

namespace Deviate\Users\Contracts\Services\Users;

interface UserValidationInterface
{
    public function validatePassword(int $userId, string $password): array;
    public function modifyActivation(int $userId, bool $isActive): array;
}
