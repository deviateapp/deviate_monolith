<?php

namespace Deviate\Activities\Services\ActivityCollections;

use Deviate\Activities\Contracts\Repositories\ActivityCollectionsRepositoryInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\FetchActivityCollectionInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\UpdateActivityCollectionInterface;
use Deviate\Activities\Validators\UpdateActivityCollectionValidator;

class UpdateActivityCollection implements UpdateActivityCollectionInterface
{
    private $repository;
    private $fetchService;
    private $validator;

    public function __construct(
        ActivityCollectionsRepositoryInterface $repository,
        FetchActivityCollectionInterface $fetchService,
        UpdateActivityCollectionValidator $validator
    ) {
        $this->repository   = $repository;
        $this->fetchService = $fetchService;
        $this->validator    = $validator;
    }

    public function updateById(string $collectionId, array $data): array
    {
        $this->validator->validate($data);

        $this->repository->update($collectionId, $data);

        return $this->fetchService->fetchById($collectionId);
    }
}
