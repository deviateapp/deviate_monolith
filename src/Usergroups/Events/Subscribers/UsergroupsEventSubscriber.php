<?php

namespace Deviate\Usergroups\Events\Subscribers;

use Deviate\Shared\Events\AbstractEventSubscriber;
use Deviate\Usergroups\Contracts\Events\UsergroupsEventSubscriberInterface;
use Deviate\Usergroups\Contracts\Services\CreateUsergroupInterface;
use Deviate\Usergroups\Contracts\Services\FetchUsergroupInterface;
use Deviate\Usergroups\Contracts\Services\DeleteUsergroupInterface;
use Deviate\Usergroups\Contracts\Services\UpdateUsergroupInterface;

class UsergroupsEventSubscriber extends AbstractEventSubscriber implements UsergroupsEventSubscriberInterface
{
    protected $events = [
        'usergroups.search'          => 'handleSearch',
        'usergroups.fetch.by_id'     => 'handleFetchUsergroupById',
        'usergroups.create'          => 'handleCreateUsergroup',
        'usergroups.update'          => 'handleUpdateUsergroup',
        'usergroups.delete'          => 'handleDeleteUsergroup',
        'usergroups.set_permissions' => 'handleSetPermissions',
    ];

    private $fetchUsergroup;
    private $createUsergroup;
    private $updateUsergroup;
    private $deleteUsergroup;

    public function __construct(
        FetchUsergroupInterface $fetchUsergroup,
        CreateUsergroupInterface $createUsergroup,
        UpdateUsergroupInterface $updateUsergroup,
        DeleteUsergroupInterface $deleteUsergroup
    ) {
        $this->fetchUsergroup  = $fetchUsergroup;
        $this->createUsergroup = $createUsergroup;
        $this->updateUsergroup = $updateUsergroup;
        $this->deleteUsergroup = $deleteUsergroup;
    }

    public function handleSearch(array $payload): array
    {
        return $this->fetchUsergroup->search(unserialize($payload['parameters']));
    }

    public function handleFetchUsergroupById(array $payload): array
    {
        return $this->fetchUsergroup->fetchById($payload['id']);
    }

    public function handleCreateUsergroup(array $payload): array
    {
        return $this->createUsergroup->createSingleUsergroup($payload);
    }

    public function handleUpdateUsergroup(array $payload): array
    {
        return $this->updateUsergroup->updateByUsergroupId($payload['id'], $payload);
    }

    public function handleDeleteUsergroup(array $payload): void
    {
        $this->deleteUsergroup->deleteById($payload['id']);
    }

    public function handleSetPermissions(array $payload): void
    {
        $this->updateUsergroup->applyPermissions($payload['id'], $payload['permissions']);
    }
}
