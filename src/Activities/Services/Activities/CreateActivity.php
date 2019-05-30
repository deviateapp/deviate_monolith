<?php

namespace Deviate\Activities\Services\Activities;

use Deviate\Activities\Contracts\Repositories\ActivitiesRepositoryInterface;
use Deviate\Activities\Contracts\Services\Activities\CreateActivityInterface;
use Deviate\Activities\Contracts\Services\Activities\FetchActivityInterface;
use Deviate\Activities\Validators\NewActivityValidator;

class CreateActivity implements CreateActivityInterface
{
    private $repository;
    private $fetchActivity;
    private $validator;

    public function __construct(
        ActivitiesRepositoryInterface $repository,
        FetchActivityInterface $fetchActivity,
        NewActivityValidator $validator
    ) {
        $this->repository    = $repository;
        $this->fetchActivity = $fetchActivity;
        $this->validator     = $validator;
    }

    public function createSingleActivity(array $data): array
    {
        $this->validator->validate([
            'activity_collection_id' => $data['activity_collection_id'] ?? null,
            'name'                   => $data['name'] ?? null,
            'description'            => $data['description'] ?? null,
            'starts_at'              => $data['starts_at'] ?? null,
            'ends_at'                => $data['ends_at'] ?? null,
            'places'                 => $data['places'] ?? null,
            'cost'                   => $data['cost'] ?? null,
            'is_hidden'              => $data['is_hidden'] ?? false,
            'is_invite_only'         => $data['is_invite_only'] ?? false,
        ]);

        $id = $this->repository->create($data);

        return $this->fetchActivity->fetchById($id);
    }
}
