<?php

namespace Deviate\Organisations\Models\Eloquent\Builders;

use Deviate\Organisations\Exceptions\OrganisationNotFoundException;
use Deviate\Shared\Models\SearchBuilderInterface;
use Deviate\Shared\Traits\Models\CanSearch;
use Deviate\Shared\Traits\Models\StandardBuilderMethods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrganisationBuilder extends Builder implements SearchBuilderInterface
{
    use CanSearch,
        StandardBuilderMethods;

    protected function throwNotFoundException(ModelNotFoundException $exception)
    {
        throw new OrganisationNotFoundException;
    }

    public function applyDefaultOrders(): Builder
    {
        return $this->orderBy('name', 'asc');
    }
}
