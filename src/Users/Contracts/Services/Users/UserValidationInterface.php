<?php

namespace Deviate\Users\Contracts\Services\Users;

interface UserValidationInterface
{
    public function validatePassword(string $userId, string $password): array;
    public function modifyActivation(string $userId, bool $isActive): array;
}
