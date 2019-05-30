<?php

namespace Deviate\Users\Models\Eloquent\Builders;

use Deviate\Shared\Models\SearchBuilderInterface;
use Deviate\Shared\Traits\Models\CanSearch;
use Deviate\Shared\Traits\Models\StandardBuilderMethods;
use Deviate\Users\Exceptions\UserNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserBuilder extends Builder implements SearchBuilderInterface
{
    use CanSearch,
        StandardBuilderMethods;

    public function forUser(int $userId): Builder
    {
        return $this->where('id', $userId);
    }

    public function forCredentials(array $credentials): Builder
    {
        return $this->where($credentials);
    }

    public function applyDefaultOrders(): Builder
    {
        return $this->orderBy('surname', 'asc')
            ->orderBy('forename', 'asc');
    }

    protected function throwNotFoundException(ModelNotFoundException $exception)
    {
        throw new UserNotFoundException;
    }
}
