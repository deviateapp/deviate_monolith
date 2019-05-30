<?php

namespace Deviate\Users\Contracts\Services\Users;

use Deviate\Shared\Search\SearchContainerInterface;

interface FetchUserInterface
{
    public function fetchById(int $id): array;
    public function fetchByRememberToken(int $organisationId, string $token): array;
    public function search(SearchContainerInterface $search): array;
}
