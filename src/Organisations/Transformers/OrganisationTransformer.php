<?php

namespace Deviate\Organisations\Transformers;

use Deviate\Shared\Transformers\CanTransformSearchResults;
use Deviate\Shared\Transformers\TransformerInterface;
use Illuminate\Database\Eloquent\Model;

class OrganisationTransformer implements TransformerInterface
{
    use CanTransformSearchResults;

    public function transform(Model $model): array
    {
        /** @var \Deviate\Organisations\Models\Eloquent\Organisation $model */
        return [
            'id'         => $model->id,
            'name'       => $model->name,
            'slug'       => $model->slug,
            'created_at' => $model->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $model->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
