<?php

namespace Deviate\Shared\Search;

use Deviate\Shared\Search\Filters\FilterInterface;
use Deviate\Shared\Search\Sorting\SortInterface;

class SearchContainer implements SearchContainerInterface
{
    private $page = 1;

    private $perPage = 20;

    private $filters = [];

    private $sorts = [];

    public function forPage(int $page = 1): SearchContainerInterface
    {
        $this->page = $page;

        return $this;
    }

    public function perPage(int $perPage = 20): SearchContainerInterface
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function addFilter(FilterInterface $filter): SearchContainerInterface
    {
        $this->filters[] = $filter;

        return $this;
    }

    public function addSort(SortInterface $sort): SearchContainerInterface
    {
        $this->sorts[] = $sort;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimitPerPage(): int
    {
        return $this->perPage;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getSorts(): array
    {
        return $this->sorts;
    }

    public function serialize()
    {
        return serialize([
            'per_page' => $this->getLimitPerPage(),
            'page'     => $this->getPage(),
            'filters'  => $this->getFilters(),
            'sorts'    => $this->getSorts(),
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $this->perPage = $data['per_page'];
        $this->page = $data['page'];
        $this->filters = $data['filters'];
        $this->sorts = $data['sorts'];
    }
}
