<?php

namespace Deviate\Users\Contracts\Services\Users;

interface UpdateUserInterface
{
    public function updatePasswordById(string $id, string $password): void;
    public function updateRememberTokenById(string $id, ?string $token): void;
    public function updateCoreDetailsById(string $id, array $data): array;
}
