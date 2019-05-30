<?php

namespace Deviate\Shared\Transformers;

use Illuminate\Database\Eloquent\Model;

interface TransformerInterface
{
    public function transform(Model $model): array;
}
