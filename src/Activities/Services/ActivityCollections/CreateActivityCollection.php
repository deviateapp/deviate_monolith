<?php

namespace Deviate\Activities\Services\ActivityCollections;

use Deviate\Activities\Contracts\Repositories\ActivityCollectionsRepositoryInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\CreateActivityCollectionInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\FetchActivityCollectionInterface;
use Deviate\Activities\Validators\NewActivityCollectionValidator;

class CreateActivityCollection implements CreateActivityCollectionInterface
{
    private $repository;
    private $fetchService;
    private $validator;

    public function __construct(
        ActivityCollectionsRepositoryInterface $repository,
        FetchActivityCollectionInterface $fetchService,
        NewActivityCollectionValidator $validator
    ) {
        $this->repository   = $repository;
        $this->fetchService = $fetchService;
        $this->validator    = $validator;
    }

    public function createSingleCollection(array $data): array
    {
        $this->validator->validate([
            'organisation_id'     => $data['organisation_id'] ?? null,
            'name'                => $data['name'] ?? null,
            'description'         => $data['description'] ?? null,
            'booking_starts_at'   => $data['booking_starts_at'] ?? null,
            'booking_ends_at'     => $data['booking_ends_at'] ?? null,
            'payment_starts_at'   => $data['payment_starts_at'] ?? null,
            'payment_ends_at'     => $data['payment_ends_at'] ?? null,
            'activities_start_at' => $data['activities_start_at'] ?? null,
            'activities_end_at'   => $data['activities_end_at'] ?? null,
        ]);

        $id = $this->repository->create($data);

        return $this->fetchService->fetchById($id);
    }
}
