<?php

namespace Deviate\Shared\Search\Filters;

use Deviate\Shared\Search\AbstractQueryApplicator;
use Illuminate\Database\Eloquent\Builder;

class MatchesFuzzy extends AbstractQueryApplicator implements FilterInterface
{
    protected $value;

    public function __construct(string $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function apply(Builder $query): Builder
    {
        return $query->where($this->field, 'LIKE', '%' . $this->value . '%');
    }
}
