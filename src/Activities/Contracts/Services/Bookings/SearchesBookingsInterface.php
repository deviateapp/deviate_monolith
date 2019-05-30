<?php

namespace Deviate\Activities\Contracts\Services\Bookings;

use Deviate\Shared\Search\SearchContainerInterface;

interface SearchesBookingsInterface
{
    public function listBookedUsers(int $activityId, SearchContainerInterface $search): array;
    public function listActivitiesBooked(int $userId, SearchContainerInterface $search): array;
}
