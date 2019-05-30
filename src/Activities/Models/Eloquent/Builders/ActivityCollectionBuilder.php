<?php

namespace Deviate\Activities\Models\Eloquent\Builders;

use Deviate\Activities\Exceptions\ActivityCollectionNotFoundException;
use Deviate\Shared\Models\SearchBuilderInterface;
use Deviate\Shared\Traits\Models\CanSearch;
use Deviate\Shared\Traits\Models\StandardBuilderMethods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActivityCollectionBuilder extends Builder implements SearchBuilderInterface
{
    use CanSearch,
        StandardBuilderMethods;

    protected function throwNotFoundException(ModelNotFoundException $exception)
    {
        throw new ActivityCollectionNotFoundException;
    }

    public function applyDefaultOrders(): Builder
    {
        return $this->orderBy('activities_start_at', 'asc');
    }
}
