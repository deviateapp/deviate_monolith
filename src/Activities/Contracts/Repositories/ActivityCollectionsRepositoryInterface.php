<?php

namespace Deviate\Activities\Contracts\Repositories;

use Deviate\Shared\Repositories\SearchableRepositoryInterface;

interface ActivityCollectionsRepositoryInterface extends SearchableRepositoryInterface
{
    public function fetchById(int $collectionId): array;
    public function create(array $data): int;
    public function fetchAll(): array;
    public function deleteById(int $collectionId): bool;
    public function update(int $collectionId, array $data): bool;
}
