<?php

namespace Deviate\Usergroups\Events\Subscribers;

use Deviate\Shared\Events\AbstractEventSubscriber;
use Deviate\Usergroups\Contracts\Events\PermissionsEventSubscriberInterface;
use Deviate\Usergroups\Contracts\Services\PermissionsInterface;

class PermissionsEventSubscriber extends AbstractEventSubscriber implements PermissionsEventSubscriberInterface
{
    protected $events = [
        'permissions.list'                  => 'handleListPermissions',
        'permissions.list.for_usergroup_id' => 'handleListPermissionsForUsergroup',
    ];

    private $permissions;

    public function __construct(PermissionsInterface $permissions)
    {
        $this->permissions = $permissions;
    }

    public function handleListPermissions(array $payload): array
    {
        return $this->permissions->sections($payload['include_permissions']);
    }

    public function handleListPermissionsForUsergroup(array $payload): array
    {
        return $this->permissions->listPermissionsInUsergroup($payload['id']);
    }
}
