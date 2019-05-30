<?php

namespace Deviate\Activities\Contracts\Repositories;

use Deviate\Shared\Repositories\SearchableRepositoryInterface;

interface ActivitiesRepositoryInterface extends SearchableRepositoryInterface
{
    public function fetchById(int $activityId): array;
    public function create(array $data): int;
    public function update(int $activityId, array $data): bool;
    public function delete(int $activityId): bool;
}
