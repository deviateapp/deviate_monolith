<?php

namespace Deviate\Users\Models\Eloquent\Builders;

use Deviate\Shared\Traits\Models\StandardBuilderMethods;
use Deviate\Users\Exceptions\UserNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AvatarBuilder extends Builder
{
    use StandardBuilderMethods;

    public function forUser(int $userId): Builder
    {
        return $this->where('user_id', $userId);
    }

    protected function throwNotFoundException(ModelNotFoundException $exception)
    {
        throw new UserNotFoundException;
    }
}
