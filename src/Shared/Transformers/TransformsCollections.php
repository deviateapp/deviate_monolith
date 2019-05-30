<?php

namespace Deviate\Shared\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait TransformsCollections
{
    public function transformCollection(Collection $collection): array
    {
        return $collection->map(function (Model $model) {
            return $this->transform($model);
        })->toArray();
    }
}
