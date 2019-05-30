<?php

namespace Deviate\Activities\Services\Bookings;

use Carbon\Carbon;
use Deviate\Activities\Client\ActivitiesClientInterface;
use Deviate\Activities\Client\CollectionsClientInterface;
use Deviate\Activities\Contracts\Repositories\BookingsRepositoryInterface;
use Deviate\Activities\Contracts\Services\Bookings\UnbookActivityInterface;
use Deviate\Activities\Exceptions\BookingNotOpenException;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Deviate\Users\Client\FetchesUsersClientInterface;

class UnbookActivity implements UnbookActivityInterface
{
    private $bookingsRepository;
    private $fetchesUsers;
    private $fetchesActivities;
    private $fetchesActivityCollections;

    public function __construct(
        BookingsRepositoryInterface $bookingsRepository,
        FetchesUsersClientInterface $fetchesUsers,
        ActivitiesClientInterface $fetchesActivities,
        CollectionsClientInterface $fetchesActivityCollections
    ) {
        $this->bookingsRepository         = $bookingsRepository;
        $this->fetchesUsers               = $fetchesUsers;
        $this->fetchesActivities          = $fetchesActivities;
        $this->fetchesActivityCollections = $fetchesActivityCollections;
    }

    public function unbookUserFromActivity(int $userId, int $activityId, bool $force = false): void
    {
        $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $activity = $this->fetchesActivities->fetchById($activityId)->rethrow();

        if (!$this->isBookingOpen($activity) && !$force) {
            throw new BookingNotOpenException;
        }

        $this->bookingsRepository->unbookUserFromActivity($userId, $activityId);
    }

    private function isBookingOpen(ApiResponseInterface $activityResponse): bool
    {
        $collection = $this->fetchesActivityCollections->fetchCollection(
            $activityResponse->get('activity_collection_id')
        );

        return Carbon::now()->between(
            Carbon::parse($collection->get('booking_starts_at')),
            Carbon::parse($collection->get('booking_ends_at'))
        );
    }
}
