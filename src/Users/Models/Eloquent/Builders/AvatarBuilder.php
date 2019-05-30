<?php

namespace Deviate\Users\Models\Eloquent\Builders;

use Deviate\Shared\Traits\ConvertsHashIds;
use Deviate\Shared\Traits\Models\StandardBuilderMethods;
use Deviate\Users\Exceptions\UserNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AvatarBuilder extends Builder
{
    use ConvertsHashIds,
        StandardBuilderMethods;

    public function forUser(string $userId): Builder
    {
        return $this->where('user_id', $this->decode($userId));
    }

    protected function throwNotFoundException(ModelNotFoundException $exception)
    {
        throw new UserNotFoundException;
    }
}
