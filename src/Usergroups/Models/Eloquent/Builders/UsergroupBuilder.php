<?php

namespace Deviate\Usergroups\Models\Eloquent\Builders;

use Deviate\Shared\Models\SearchBuilderInterface;
use Deviate\Shared\Traits\Models\CanSearch;
use Deviate\Shared\Traits\Models\StandardBuilderMethods;
use Deviate\Usergroups\Exceptions\UsergroupNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsergroupBuilder extends Builder implements SearchBuilderInterface
{
    use CanSearch,
        StandardBuilderMethods;

    public function applyDefaultOrders(): Builder
    {
        return $this->orderBy('name', 'asc');
    }

    protected function throwNotFoundException(ModelNotFoundException $exception)
    {
        throw new UsergroupNotFoundException;
    }
}
