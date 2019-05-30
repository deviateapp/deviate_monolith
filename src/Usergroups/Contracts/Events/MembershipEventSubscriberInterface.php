<?php

namespace Deviate\Usergroups\Contracts\Events;

use Deviate\Shared\Events\EventSubscriberInterface as BaseEventSubscriberInterface;

interface MembershipEventSubscriberInterface extends BaseEventSubscriberInterface
{
    public function handleJoin(array $payload): void;
    public function handleRemove(array $payload): void;
    public function handleRemoveByUserId(array $payload): void;
    public function handleRemoveByUsergroupId(array $payload): void;
    public function handleListMembers(array $payload): array;
}
