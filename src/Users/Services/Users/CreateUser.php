<?php

namespace Deviate\Users\Services\Users;

use Deviate\Users\Contracts\Repositories\CreateUsersRepositoryInterface;
use Deviate\Users\Contracts\Repositories\FetchUsersRepositoryInterface;
use Deviate\Users\Contracts\Services\Avatars\CreateAvatarInterface;
use Deviate\Users\Contracts\Services\Users\CreateUserInterface;
use Deviate\Users\Validators\NewUserValidator;
use Illuminate\Contracts\Hashing\Hasher;

class CreateUser implements CreateUserInterface
{
    /** @var CreateUsersRepositoryInterface */
    private $createsUsers;

    /** @var FetchUsersRepositoryInterface */
    private $fetchesUsers;

    /** @var NewUserValidator */
    private $validator;

    /** @var Hasher */
    private $hasher;

    /** @var CreateAvatarInterface */
    private $createAvatar;

    public function __construct(
        CreateUsersRepositoryInterface $createsUsers,
        FetchUsersRepositoryInterface $fetchesUsers,
        NewUserValidator $validator,
        Hasher $hasher,
        CreateAvatarInterface $createAvatar
    ) {
        $this->createsUsers = $createsUsers;
        $this->fetchesUsers = $fetchesUsers;
        $this->validator    = $validator;
        $this->hasher       = $hasher;
        $this->createAvatar = $createAvatar;
    }

    public function createSingleUser(array $data): array
    {
        $this->validator->validate([
            'organisation_id' => $data['organisation_id'] ?? null,
            'forename'        => $data['forename'] ?? null,
            'surname'         => $data['surname'] ?? null,
            'email'           => $data['email'] ?? null,
            'password'        => $data['password'] ?? null,
        ]);

        $data['password'] = $this->hasher->make($data['password']);

        $id = $this->createsUsers->createUser($data);

        $this->createAvatar->createDefaultAvatar($id);

        return $this->fetchesUsers->fetchUserById($id);
    }
}
