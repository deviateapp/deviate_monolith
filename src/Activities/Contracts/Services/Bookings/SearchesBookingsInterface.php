<?php

namespace Deviate\Activities\Contracts\Services\Bookings;

use Deviate\Shared\Search\SearchContainerInterface;

interface SearchesBookingsInterface
{
    public function listBookedUsers(string $activityId, SearchContainerInterface $search): array;
    public function listActivitiesBooked(string $userId, SearchContainerInterface $search): array;
}
