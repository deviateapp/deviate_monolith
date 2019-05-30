<?php

namespace Deviate\Users\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Users\Contracts\Repositories\FetchAvatarsRepositoryInterface;
use Deviate\Users\Models\Eloquent\Avatar;
use Deviate\Users\Transformers\AvatarTransformer;

class FetchAvatarsRepository extends AbstractRepository implements FetchAvatarsRepositoryInterface
{
    /** @var Avatar */
    private $avatar;

    /** @var AvatarTransformer */
    private $transformer;

    public function __construct(Avatar $avatar, AvatarTransformer $transformer)
    {
        $this->avatar      = $avatar;
        $this->transformer = $transformer;
    }

    public function fetchAvatarByUserId(string $userId): array
    {
        /** @var Avatar $avatar */
        $avatar = $this->avatar->newQuery()->where('user_id', $userId)->firstOrFail();

        return $this->transformer->transform($avatar);
    }

    public function hasAvatar(string $userId): bool
    {
        return (bool) $this->avatar->newQuery()->where('user_id', $userId)->exists();
    }
}
