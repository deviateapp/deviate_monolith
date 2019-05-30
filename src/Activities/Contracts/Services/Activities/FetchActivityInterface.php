<?php

namespace Deviate\Activities\Contracts\Services\Activities;

use Deviate\Shared\Search\SearchContainerInterface;

interface FetchActivityInterface
{
    public function search(SearchContainerInterface $search): array;
    public function fetchById(int $activityId): array;
}
