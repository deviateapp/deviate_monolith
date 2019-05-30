<?php

namespace Deviate\Activities\Contracts\Repositories;

use Deviate\Shared\Repositories\SearchableRepositoryInterface;

interface ActivityCollectionsRepositoryInterface extends SearchableRepositoryInterface
{
    public function fetchById(string $collectionId): array;
    public function create(array $data): string;
    public function fetchAll(): array;
    public function deleteById(string $collectionId): bool;
    public function update(string $collectionId, array $data): bool;
}
