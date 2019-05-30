<?php

namespace Deviate\Users\Contracts\Services\Users;

interface UpdateUserInterface
{
    public function updatePasswordById(int $id, string $password): void;
    public function updateRememberTokenById(int $id, ?string $token): void;
    public function updateCoreDetailsById(int $id, array $data): array;
}
