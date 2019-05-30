<?php

namespace Deviate\Shared\Transformers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait CanTransformSearchResults
{
    public function transformSearch(LengthAwarePaginator $paginator)
    {
        return $this->searchTransformer()->transform($paginator, $this);
    }

    public function searchTransformer(): SearchResultTransformer
    {
        return app(SearchResultTransformer::class);
    }
}
