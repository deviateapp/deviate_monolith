<?php

namespace Deviate\Activities\Contracts\Events;

use Deviate\Shared\Events\EventSubscriberInterface;

interface BookingsEventSubscriberInterface extends EventSubscriberInterface
{
    public function handleBook(array $payload): void;
    public function handleUnbook(array $payload): void;
    public function handleListBookedUsers(array $payload): array;
    public function handleListActivitiesBooked(array $payload): array;
}
