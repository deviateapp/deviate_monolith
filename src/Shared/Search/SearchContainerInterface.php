<?php

namespace Deviate\Shared\Search;

use Deviate\Shared\Search\Filters\FilterInterface;
use Deviate\Shared\Search\Sorting\SortInterface;
use Serializable;

interface SearchContainerInterface extends Serializable
{
    public function forPage(int $page = 1): SearchContainerInterface;
    public function perPage(int $perPage = 20): SearchContainerInterface;

    public function addFilter(FilterInterface $filter): SearchContainerInterface;
    public function addSort(SortInterface $sort): SearchContainerInterface;

    public function getPage(): int;
    public function getLimitPerPage(): int;
    public function getFilters(): array;
    public function getSorts(): array;
}
