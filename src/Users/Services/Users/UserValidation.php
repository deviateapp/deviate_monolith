<?php

namespace Deviate\Users\Services\Users;

use Deviate\Users\Contracts\Repositories\FetchUsersRepositoryInterface;
use Deviate\Users\Contracts\Repositories\UpdateUsersRepositoryInterface;
use Deviate\Users\Contracts\Services\Users\UserValidationInterface;
use Illuminate\Contracts\Hashing\Hasher;

class UserValidation implements UserValidationInterface
{
    /** @var FetchUsersRepositoryInterface */
    private $fetchesUsers;

    /** @var UpdateUsersRepositoryInterface */
    private $updatesUsers;

    /** @var Hasher */
    private $hasher;

    public function __construct(
        FetchUsersRepositoryInterface $fetchesUsers,
        UpdateUsersRepositoryInterface $repository,
        Hasher $hasher
    ) {
        $this->fetchesUsers = $fetchesUsers;
        $this->updatesUsers = $repository;
        $this->hasher       = $hasher;
    }

    public function validatePassword(int $userId, string $password): array
    {
        $storedPassword = $this->fetchesUsers->fetchPasswordById($userId);

        return [
            'valid' => $this->hasher->check($password, $storedPassword),
        ];
    }

    public function modifyActivation(int $userId, bool $isActive): array
    {
        $this->updatesUsers->updateActivationById($userId, $isActive);

        return $this->fetchesUsers->fetchUserById($userId);
    }
}
