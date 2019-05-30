<?php

namespace Deviate\Users\Repositories;

use Deviate\Shared\Search\SearchContainerInterface;
use Deviate\Users\Contracts\Repositories\FetchUsersRepositoryInterface;
use Deviate\Users\Models\Eloquent\User;
use Deviate\Users\Transformers\UserTransformer;

class FetchUsersRepository implements FetchUsersRepositoryInterface
{
    /** @var User */
    private $user;

    /** @var UserTransformer */
    private $transformer;

    public function __construct(User $user, UserTransformer $transformer)
    {
        $this->user        = $user;
        $this->transformer = $transformer;
    }

    public function search(SearchContainerInterface $search): array
    {
        $paginator = $this->user->newQuery()->search($search);

        return $this->transformer->transformSearch($paginator);
    }

    public function fetchUserByCredentials(array $data): array
    {
        $user = $this->user->newQuery()->withTrashed()->where($data)->firstOrFail();

        return $this->transformer->transform($user);
    }

    public function fetchPasswordById(int $id): string
    {
        return $this->user->newQuery()->withTrashed()->findOrFail($id)->password;
    }

    public function fetchUserById(int $id): array
    {
        $user = $this->user->newQuery()->withTrashed()->findOrFail($id);

        return $this->transformer->transform($user);
    }
}
