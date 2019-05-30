<?php

namespace Deviate\Shared\Models;

use Deviate\Shared\Search\SearchContainerInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

interface SearchBuilderInterface
{
    public function search(SearchContainerInterface $search): LengthAwarePaginator;
    public function applyDefaultOrders(): Builder;
}
