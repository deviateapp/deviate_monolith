<?php

namespace Deviate\Activities\Contracts\Events;

use Deviate\Shared\Events\EventSubscriberInterface;

interface InvitationsEventSubscriberInterface extends EventSubscriberInterface
{
    public function handleInvite(array $payload): void;
    public function handleUninvite(array $payload): void;
    public function handleListInvitedUsers(array $payload): array;
    public function handleListInvites(array $payload): array;
}
