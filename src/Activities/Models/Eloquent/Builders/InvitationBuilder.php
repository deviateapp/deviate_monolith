<?php

namespace Deviate\Activities\Models\Eloquent\Builders;

use Deviate\Activities\Exceptions\InvitationNotFoundException;
use Deviate\Shared\Traits\Models\StandardBuilderMethods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class InvitationBuilder extends Builder
{
    use StandardBuilderMethods;

    public function create(array $attributes = [])
    {
        return parent::create(
            Arr::only($attributes, ['activity_id', 'user_id']) + ['status' => 'invited']
        );
    }

    protected function throwNotFoundException(ModelNotFoundException $exception)
    {
        throw new InvitationNotFoundException;
    }
}
