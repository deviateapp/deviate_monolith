<?php

namespace Deviate\Shared\Search;

use Illuminate\Database\Eloquent\Builder;

interface QueryApplicatorInterface
{
    public function apply(Builder $query): Builder;
    public function transformField(array $map): QueryApplicatorInterface;
    public function isWhitelisted(array $whitelist): bool;
}
