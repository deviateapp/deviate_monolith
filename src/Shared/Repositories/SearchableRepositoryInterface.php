<?php

namespace Deviate\Shared\Repositories;

use Deviate\Shared\Search\SearchContainerInterface;

interface SearchableRepositoryInterface
{
    public function search(SearchContainerInterface $search): array;
}
