<?php

namespace Deviate\Shared\Search\Filters;

use Deviate\Shared\Search\AbstractQueryApplicator;
use Deviate\Shared\Traits\ConvertsHashIds;
use Illuminate\Database\Eloquent\Builder;

class MustBeIn extends AbstractQueryApplicator implements FilterInterface
{
    use ConvertsHashIds;

    protected $values;

    public function __construct(string $field, $values)
    {
        $this->field  = $field;
        $this->values = $values;
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereIn($this->field, array_map(function ($value) {
            return $this->decode($value);
        }, $this->values));
    }
}
