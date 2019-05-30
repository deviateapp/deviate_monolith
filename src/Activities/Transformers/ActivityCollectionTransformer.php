<?php

namespace Deviate\Activities\Transformers;

use Deviate\Shared\Traits\ConvertsHashIds;
use Deviate\Shared\Transformers\CanTransformSearchResults;
use Deviate\Shared\Transformers\TransformerInterface;
use Deviate\Shared\Transformers\TransformsCollections;
use Illuminate\Database\Eloquent\Model;

class ActivityCollectionTransformer implements TransformerInterface
{
    use ConvertsHashIds,
        TransformsCollections,
        CanTransformSearchResults;

    public function transform(Model $collection): array
    {
        /** @var \Deviate\Activities\Models\Eloquent\ActivityCollection $collection */
        return [
            'id'                  => $this->encode($collection->id),
            'organisation_id'     => $this->encode($collection->organisation_id),
            'name'                => $collection->name,
            'description'         => $collection->description,
            'booking_starts_at'   => $collection->booking_starts_at->format('Y-m-d H:i:s'),
            'booking_ends_at'     => $collection->booking_ends_at->format('Y-m-d H:i:s'),
            'payment_starts_at'   => $collection->payment_starts_at->format('Y-m-d H:i:s'),
            'payment_ends_at'     => $collection->payment_ends_at->format('Y-m-d H:i:s'),
            'activities_start_at' => $collection->activities_start_at->format('Y-m-d H:i:s'),
            'activities_end_at'   => $collection->activities_end_at->format('Y-m-d H:i:s'),
            'created_at'          => $collection->created_at->format('Y-m-d H:i:s'),
            'updated_at'          => $collection->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
