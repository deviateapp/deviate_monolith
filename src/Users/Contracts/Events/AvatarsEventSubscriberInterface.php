<?php

namespace Deviate\Users\Contracts\Events;

use Deviate\Shared\Events\EventSubscriberInterface as BaseEventSubscriberInterface;

interface AvatarsEventSubscriberInterface extends BaseEventSubscriberInterface
{
    public function handleStoreAvatar(array $payload): array;
    public function handleCreateDefaultAvatar(array $payload): array;
    public function handleFetchAvatar(array $payload): array;
    public function handleDeleteAvatar(array $payload): void;
}
