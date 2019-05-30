<?php

namespace Deviate\Shared\Search\Sorting;

use Deviate\Shared\Search\AbstractQueryApplicator;
use Illuminate\Database\Eloquent\Builder;

class RegularSort extends AbstractQueryApplicator implements SortInterface
{
    protected $direction;

    private function __construct(string $field, string $direction)
    {
        $this->field     = $field;
        $this->direction = $direction;
    }

    public static function ascending(string $field)
    {
        return new static($field, 'asc');
    }

    public static function descending(string $field)
    {
        return new static($field, 'desc');
    }

    public function apply(Builder $query): Builder
    {
        return $query->orderBy($this->field, $this->direction);
    }
}
