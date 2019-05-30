<?php

namespace Deviate\Usergroups\Contracts\Repositories;

use Deviate\Shared\Repositories\SearchableRepositoryInterface;

interface FetchUsergroupsRepositoryInterface extends SearchableRepositoryInterface
{
    public function fetchById(int $id): array;
    public function isNameRegistered(int $organisationId, string $name, ?int $excludeId = null): bool;
}
