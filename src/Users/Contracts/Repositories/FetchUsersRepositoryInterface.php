<?php

namespace Deviate\Users\Contracts\Repositories;

use Deviate\Shared\Repositories\SearchableRepositoryInterface;

interface FetchUsersRepositoryInterface extends SearchableRepositoryInterface
{
    public function fetchUserById(string $id): array;
    public function fetchUserByCredentials(array $data): array;
    public function fetchPasswordById(string $id): string;
}
