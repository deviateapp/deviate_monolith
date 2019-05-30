<?php

namespace Deviate\Users\Services\Users;

use Deviate\Users\Contracts\Repositories\FetchUsersRepositoryInterface;
use Deviate\Users\Contracts\Repositories\UpdateUsersRepositoryInterface;
use Deviate\Users\Contracts\Services\Users\UpdateUserInterface;
use Deviate\Users\Validators\UpdateCoreDetailsValidator;
use Deviate\Users\Validators\UpdatePasswordValidator;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Arr;

class UpdateUser implements UpdateUserInterface
{
    /** @var UpdateUsersRepositoryInterface */
    private $updatesUsers;

    /** @var FetchUsersRepositoryInterface */
    private $fetchesUsers;

    /** @var Hasher */
    private $hasher;

    /** @var UpdatePasswordValidator */
    private $passwordValidator;

    /** @var UpdateCoreDetailsValidator */
    private $coreDetailsValidator;

    public function __construct(
        UpdateUsersRepositoryInterface $updatesUsers,
        FetchUsersRepositoryInterface $fetchesUsers,
        Hasher $hasher,
        UpdatePasswordValidator $passwordValidator,
        UpdateCoreDetailsValidator $coreDetailsValidator
    ) {
        $this->updatesUsers         = $updatesUsers;
        $this->fetchesUsers         = $fetchesUsers;
        $this->hasher               = $hasher;
        $this->passwordValidator    = $passwordValidator;
        $this->coreDetailsValidator = $coreDetailsValidator;
    }

    public function updatePasswordById(string $id, string $password): void
    {
        $this->passwordValidator->validate([
            'password' => $password,
        ]);

        $this->updatesUsers->updateUserById($id, [
            'password' => $this->hasher->make($password),
        ]);
    }

    public function updateRememberTokenById(string $id, ?string $token): void
    {
        $this->updatesUsers->updateUserById($id, [
            'remember_token' => $token,
        ]);
    }

    public function updateCoreDetailsById(string $id, array $data): array
    {
        $user = $this->fetchesUsers->fetchUserById($id);

        $this->coreDetailsValidator->validate($data, [
            'id'              => $id,
            'organisation_id' => $user['organisation_id'],
        ]);

        $this->updatesUsers->updateUserById($id, Arr::only($data, ['forename', 'surname', 'email']));

        return $this->fetchesUsers->fetchUserById($id);
    }
}
