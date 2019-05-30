<?php

namespace Deviate\Activities\Contracts\Repositories;

use Deviate\Shared\Repositories\SearchableRepositoryInterface;

interface ActivitiesRepositoryInterface extends SearchableRepositoryInterface
{
    public function fetchById(string $activityId): array;
    public function create(array $data): string;
    public function update(string $activityId, array $data): bool;
    public function delete(string $activityId): bool;
}
