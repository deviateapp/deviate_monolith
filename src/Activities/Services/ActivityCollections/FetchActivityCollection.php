<?php

namespace Deviate\Activities\Services\ActivityCollections;

use Deviate\Activities\Contracts\Repositories\ActivityCollectionsRepositoryInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\FetchActivityCollectionInterface;
use Deviate\Activities\Normalizers\ActivityCollectionSearchNormalizer;
use Deviate\Shared\Search\SearchContainerInterface;

class FetchActivityCollection implements FetchActivityCollectionInterface
{
    private $repository;
    private $normalizer;

    public function __construct(
        ActivityCollectionsRepositoryInterface $repository,
        ActivityCollectionSearchNormalizer $normalizer
    ) {
        $this->repository = $repository;
        $this->normalizer = $normalizer;
    }

    public function fetchById(int $collectionId): array
    {
        return $this->repository->fetchById($collectionId);
    }

    public function search(SearchContainerInterface $search): array
    {
        return $this->repository->search($this->normalizer->normalize($search));
    }
}
