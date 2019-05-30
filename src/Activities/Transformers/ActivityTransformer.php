<?php

namespace Deviate\Activities\Transformers;

use Deviate\Shared\Traits\ConvertsHashIds;
use Deviate\Shared\Transformers\CanTransformSearchResults;
use Deviate\Shared\Transformers\TransformerInterface;
use Deviate\Shared\Transformers\TransformsCollections;
use Illuminate\Database\Eloquent\Model;

class ActivityTransformer implements TransformerInterface
{
    use ConvertsHashIds,
        TransformsCollections,
        CanTransformSearchResults;

    public function transform(Model $model): array
    {
        /** @var \Deviate\Activities\Models\Eloquent\Activity $model */
        return [
            'id'                     => $this->encode($model->id),
            'organisation_id'        => $this->encode($model->organisation_id),
            'activity_collection_id' => $this->encode($model->activity_collection_id),
            'name'                   => $model->name,
            'description'            => $model->description,
            'starts_at'              => $model->starts_at->format('Y-m-d'),
            'ends_at'                => $model->ends_at->format('Y-m-d'),
            'places'                 => (int) $model->places,
            'cost'                   => (int) $model->cost,
            'is_hidden'              => (bool) $model->is_hidden,
            'is_invite_only'         => (bool) $model->is_invite_only,
            'created_at'             => $model->created_at->format('Y-m-d H:i:s'),
            'updated_at'             => $model->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
