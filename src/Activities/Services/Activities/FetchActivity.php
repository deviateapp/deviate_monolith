<?php

namespace Deviate\Activities\Services\Activities;

use Deviate\Activities\Contracts\Repositories\ActivitiesRepositoryInterface;
use Deviate\Activities\Contracts\Services\Activities\FetchActivityInterface;
use Deviate\Activities\Normalizers\ActivitySearchNormalizer;
use Deviate\Shared\Search\SearchContainerInterface;

class FetchActivity implements FetchActivityInterface
{
    private $repository;
    private $normalizer;

    public function __construct(ActivitiesRepositoryInterface $repository, ActivitySearchNormalizer $normalizer)
    {
        $this->repository = $repository;
        $this->normalizer = $normalizer;
    }

    public function search(SearchContainerInterface $search): array
    {
         return $this->repository->search($this->normalizer->normalize($search));
    }

    public function fetchById(string $activityId): array
    {
        return $this->repository->fetchById($activityId);
    }
}
