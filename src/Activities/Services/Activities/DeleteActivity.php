<?php

namespace Deviate\Activities\Services\Activities;

use Deviate\Activities\Contracts\Repositories\ActivitiesRepositoryInterface;
use Deviate\Activities\Contracts\Services\Activities\DeleteActivityInterface;

class DeleteActivity implements DeleteActivityInterface
{
    private $repository;

    public function __construct(ActivitiesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function deleteById(string $activityId): void
    {
        $this->repository->delete($activityId);
    }
}
