<?php

namespace Deviate\Users\Services\Users;

use Deviate\Shared\Search\SearchContainerInterface;
use Deviate\Users\Contracts\Repositories\FetchUsersRepositoryInterface;
use Deviate\Users\Contracts\Services\Users\FetchUserInterface;
use Deviate\Users\Normalizers\UserSearchNormalizer;

class FetchUser implements FetchUserInterface
{
    /** @var FetchUsersRepositoryInterface */
    private $fetchesUsers;

    /** @var UserSearchNormalizer */
    private $normalizer;

    public function __construct(FetchUsersRepositoryInterface $fetchesUsers, UserSearchNormalizer $normalizer)
    {
        $this->fetchesUsers = $fetchesUsers;
        $this->normalizer   = $normalizer;
    }

    public function fetchById(string $id): array
    {
        return $this->fetchesUsers->fetchUserById($id);
    }

    public function fetchByRememberToken(string $organisationId, string $token): array
    {
        return $this->fetchesUsers->fetchUserByCredentials([
            'organisation_id' => $organisationId,
            'remember_token'  => $token,
        ]);
    }

    public function search(SearchContainerInterface $search): array
    {
        return $this->fetchesUsers->search($this->normalizer->normalize($search));
    }
}
