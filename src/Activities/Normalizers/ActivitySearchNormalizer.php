<?php

namespace Deviate\Activities\Normalizers;

use Deviate\Shared\Search\AbstractSearchNormalizer;

class ActivitySearchNormalizer extends AbstractSearchNormalizer
{
    protected function map(): array
    {
        return [
            'id'         => 'id',
            'collection' => 'activity_collection_id',
            'name'       => 'name',
            'places'     => 'places',
            'cost'       => 'cost',
            'starts'     => 'starts_at',
            'ends'       => 'ends_at',
            'created'    => 'created_at',
            'updated'    => 'updated_at',
        ];
    }

    protected function whitelist(): array
    {
        return ['id', 'collection', 'name', 'places', 'cost', 'starts', 'ends', 'created', 'updated'];
    }
}
