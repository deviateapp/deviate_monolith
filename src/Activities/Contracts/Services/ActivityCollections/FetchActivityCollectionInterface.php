<?php

namespace Deviate\Activities\Contracts\Services\ActivityCollections;

use Deviate\Shared\Search\SearchContainerInterface;

interface FetchActivityCollectionInterface
{
    public function fetchById(int $collectionId): array;
    public function search(SearchContainerInterface $search): array;
}
