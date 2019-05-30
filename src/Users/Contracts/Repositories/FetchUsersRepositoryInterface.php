<?php

namespace Deviate\Users\Contracts\Repositories;

use Deviate\Shared\Repositories\SearchableRepositoryInterface;

interface FetchUsersRepositoryInterface extends SearchableRepositoryInterface
{
    public function fetchUserById(int $id): array;
    public function fetchUserByCredentials(array $data): array;
    public function fetchPasswordById(int $id): string;
}
