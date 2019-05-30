<?php

namespace Deviate\Activities\Contracts\Events;

use Deviate\Shared\Events\EventSubscriberInterface;

interface ActivitiesEventSubscriberInterface extends EventSubscriberInterface
{
    public function handleSearchActivities(array $payload): array;
    public function handleFetchActivity(array $payload): array;
    public function handleCreateActivity(array $payload): array;
    public function handleUpdateActivity(array $payload): array;
    public function handleDeleteActivity(array $payload): void;
}
