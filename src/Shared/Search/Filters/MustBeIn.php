<?php

namespace Deviate\Shared\Search\Filters;

use Deviate\Shared\Search\AbstractQueryApplicator;
use Illuminate\Database\Eloquent\Builder;

class MustBeIn extends AbstractQueryApplicator implements FilterInterface
{
    protected $values;

    public function __construct(string $field, $values)
    {
        $this->field  = $field;
        $this->values = $values;
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereIn($this->field, $this->values);
    }
}
