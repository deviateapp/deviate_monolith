<?php

namespace Deviate\Users\Events\Subscribers;

use Deviate\Shared\Events\AbstractEventSubscriber;
use Deviate\Users\Contracts\Events\UsersEventSubscriberInterface;
use Deviate\Users\Contracts\Services\Users\CreateUserInterface;
use Deviate\Users\Contracts\Services\Users\DeleteUserInterface;
use Deviate\Users\Contracts\Services\Users\FetchUserInterface;
use Deviate\Users\Contracts\Services\Users\UpdateUserInterface;
use Deviate\Users\Contracts\Services\Users\UserValidationInterface;

class UsersEventSubscriber extends AbstractEventSubscriber implements UsersEventSubscriberInterface
{
    protected $events = [
        'users.create'                           => 'handleCreateUser',
        'users.fetch.by_id'                      => 'handleFetchUserById',
        'users.fetch.by_remember_token'          => 'handleFetchUserByRememberToken',
        'users.update.password'                  => 'handleUpdatePassword',
        'users.update.remember_token'            => 'handleUpdateRememberToken',
        'users.update.core_details'              => 'handleUpdateCoreDetails',
        'users.authentication.validate_password' => 'handleValidatePassword',
        'users.authentication.modify_activation' => 'handleUserActivation',
        'users.authentication.delete'            => 'handleDeleteUser',
    ];

    private $createUser;
    private $fetchUser;
    private $updateUser;
    private $deleteUser;
    private $userValidation;

    public function __construct(
        CreateUserInterface $createUser,
        FetchUserInterface $fetchUser,
        UpdateUserInterface $updateUser,
        DeleteUserInterface $deleteUser,
        UserValidationInterface $userValidation
    ) {
        $this->createUser     = $createUser;
        $this->fetchUser      = $fetchUser;
        $this->updateUser     = $updateUser;
        $this->deleteUser     = $deleteUser;
        $this->userValidation = $userValidation;
    }

    public function handleCreateUser(array $payload): array
    {
        return $this->createUser->createSingleUser($payload);
    }

    public function handleFetchUserById(array $payload): array
    {
        return $this->fetchUser->fetchById($payload['id']);
    }

    public function handleFetchUserByRememberToken(array $payload): array
    {
        return $this->fetchUser->fetchByRememberToken($payload['organisation_id'], $payload['remember_token']);
    }

    public function handleUpdatePassword(array $payload): void
    {
        $this->updateUser->updatePasswordById($payload['id'], $payload['password']);
    }

    public function handleUpdateRememberToken(array $payload): void
    {
        $this->updateUser->updateRememberTokenById($payload['id'], $payload['token']);
    }

    public function handleUpdateCoreDetails(array $payload): array
    {
        return $this->updateUser->updateCoreDetailsById($payload['id'], $payload);
    }

    public function handleValidatePassword(array $payload): array
    {
        return $this->userValidation->validatePassword($payload['id'], $payload['password']);
    }

    public function handleUserActivation(array $payload): array
    {
        return $this->userValidation->modifyActivation($payload['id'], $payload['active']);
    }

    public function handleDeleteUser(array $payload): void
    {
        $this->deleteUser->deleteUser($payload['id']);
    }
}
