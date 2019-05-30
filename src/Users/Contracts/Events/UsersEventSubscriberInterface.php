<?php

namespace Deviate\Users\Contracts\Events;

use Deviate\Shared\Events\EventSubscriberInterface as BaseEventSubscriberInterface;

interface UsersEventSubscriberInterface extends BaseEventSubscriberInterface
{
    public function handleCreateUser(array $payload): array;

    public function handleFetchUserById(array $payload): array;
    public function handleFetchUserByRememberToken(array $payload): array;

    public function handleUpdatePassword(array $payload): void;
    public function handleUpdateRememberToken(array $payload): void;
    public function handleUpdateCoreDetails(array $payload): array;

    public function handleValidatePassword(array $payload): array;

    public function handleUserActivation(array $payload): array;
    public function handleDeleteUser(array $payload): void;
}
