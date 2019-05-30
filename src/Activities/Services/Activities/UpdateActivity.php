<?php

namespace Deviate\Activities\Services\Activities;

use Deviate\Activities\Contracts\Repositories\ActivitiesRepositoryInterface;
use Deviate\Activities\Contracts\Services\Activities\FetchActivityInterface;
use Deviate\Activities\Contracts\Services\Activities\UpdateActivityInterface;
use Deviate\Activities\Validators\UpdateActivityValidator;

class UpdateActivity implements UpdateActivityInterface
{
    private $repository;
    private $fetchActivity;
    private $validator;

    public function __construct(
        ActivitiesRepositoryInterface $repository,
        FetchActivityInterface $fetchActivity,
        UpdateActivityValidator $validator
    ) {
        $this->repository = $repository;
        $this->fetchActivity = $fetchActivity;
        $this->validator = $validator;
    }

    public function updateById(string $activityId, array $data): array
    {
        $this->validator->validate($data);

        $this->repository->update($activityId, $data);

        return $this->fetchActivity->fetchById($activityId);
    }
}
