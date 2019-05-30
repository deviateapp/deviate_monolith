<?php

namespace Deviate\Shared\Transformers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class SearchResultTransformer
{
    public function transform(LengthAwarePaginator $paginator, TransformerInterface $baseTransformer): array
    {
        return [
            'meta' => [
                'current_page'  => $paginator->currentPage(),
                'per_page'      => $paginator->perPage(),
                'total_pages'   => $paginator->lastPage(),
                'total_records' => $paginator->total(),
            ],
            'data' => $paginator->getCollection()->map(function (Model $organisation) use ($baseTransformer) {
                return $baseTransformer->transform($organisation);
            })->toArray(),
        ];
    }
}
