<?php

namespace Deviate\Usergroups\Contracts\Repositories;

use Deviate\Shared\Repositories\SearchableRepositoryInterface;

interface FetchUsergroupsRepositoryInterface extends SearchableRepositoryInterface
{
    public function fetchById(string $id): array;
    public function isNameRegistered(string $organisationId, string $name, ?string $excludeId = null): bool;
}
