<?php

namespace Deviate\Activities\Services\ActivityCollections;

use Deviate\Activities\Contracts\Repositories\ActivityCollectionsRepositoryInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\DeleteActivityCollectionInterface;

class DeleteActivityCollection implements DeleteActivityCollectionInterface
{
    private $repository;

    public function __construct(ActivityCollectionsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function deleteById(int $collectionId): void
    {
        $this->repository->deleteById($collectionId);
    }
}
