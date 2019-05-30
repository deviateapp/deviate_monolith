<?php

namespace Deviate\Usergroups\Contracts\Events;

use Deviate\Shared\Events\EventSubscriberInterface as BaseEventSubscriberInterface;

interface PermissionsEventSubscriberInterface extends BaseEventSubscriberInterface
{
    public function handleListPermissions(array $payload): array;
    public function handleListPermissionsForUsergroup(array $payload): array;
}
