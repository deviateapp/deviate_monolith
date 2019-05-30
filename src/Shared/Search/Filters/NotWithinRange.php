<?php

namespace Deviate\Shared\Search\Filters;

use Deviate\Shared\Search\AbstractQueryApplicator;
use Illuminate\Database\Eloquent\Builder;

class NotWithinRange extends AbstractQueryApplicator implements FilterInterface
{
    protected $start;
    protected $end;
    protected $inclusive;

    public function __construct(string $field, $start, $end, bool $inclusive = true)
    {
        $this->field     = $field;
        $this->start     = $start;
        $this->end       = $end;
        $this->inclusive = $inclusive;
    }

    public function apply(Builder $query): Builder
    {
        if ($this->inclusive) {
            return $this->build($query, '<=', '>=');
        }

        return $this->build($query, '<', '>');
    }

    private function build(Builder $query, string $startOperator, string $endOperator): Builder
    {
        return $query->where(function (Builder $query) use ($startOperator, $endOperator) {
            return $query->where($this->field, $startOperator, $this->start)
                ->orWhere($this->field, $endOperator, $this->end);
        });
    }
}
