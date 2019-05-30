<?php

namespace Deviate\Users\Contracts\Services\Users;

use Deviate\Shared\Search\SearchContainerInterface;

interface FetchUserInterface
{
    public function fetchById(string $id): array;
    public function fetchByRememberToken(string $organisationId, string $token): array;
    public function search(SearchContainerInterface $search): array;
}
