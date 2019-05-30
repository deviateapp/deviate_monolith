<?php

namespace Deviate\Usergroups\Contracts\Events;

use Deviate\Users\Contracts\Events\SearchEventSubscriberInterface;

interface UsergroupsEventSubscriberInterface extends SearchEventSubscriberInterface
{
    public function handleFetchUsergroupById(array $payload): array;
    public function handleCreateUsergroup(array $payload): array;
    public function handleUpdateUsergroup(array $payload): array;
    public function handleDeleteUsergroup(array $payload): void;

    public function handleSetPermissions(array $payload): void;
}
