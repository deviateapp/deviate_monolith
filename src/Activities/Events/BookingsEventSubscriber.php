<?php

namespace Deviate\Activities\Events;

use Deviate\Activities\Contracts\Events\BookingsEventSubscriberInterface;
use Deviate\Activities\Contracts\Services\Bookings\BookActivityInterface;
use Deviate\Activities\Contracts\Services\Bookings\UnbookActivityInterface;
use Deviate\Activities\Contracts\Services\Bookings\SearchesBookingsInterface;
use Deviate\Shared\Events\AbstractEventSubscriber;
use Deviate\Shared\Traits\ConvertsHashIds;

class BookingsEventSubscriber extends AbstractEventSubscriber implements BookingsEventSubscriberInterface
{
    use ConvertsHashIds;

    protected $events = [
        'activities.book'                                => 'handleBook',
        'activities.unbook'                              => 'handleUnbook',
        'activities.bookings.search.users_on_activity'   => 'handleListBookedUsers',
        'activities.bookings.search.activities_for_user' => 'handleListActivitiesBooked',
    ];

    private $booksActivities;
    private $unbooksActivities;
    private $searchesBookings;

    public function __construct(
        BookActivityInterface $booksActivities,
        UnbookActivityInterface $unbooksActivities,
        SearchesBookingsInterface $searchesBookings
    ) {
        $this->booksActivities   = $booksActivities;
        $this->unbooksActivities = $unbooksActivities;
        $this->searchesBookings  = $searchesBookings;
    }

    public function handleBook(array $payload): void
    {
        $this->booksActivities->bookUserOnActivity(
            $payload['user_id'],
            $payload['activity_id'],
            $payload['force_booking']
        );
    }

    public function handleUnbook(array $payload): void
    {
        $this->unbooksActivities->unbookUserFromActivity(
            $payload['user_id'],
            $payload['activity_id'],
            $payload['force_unbooking']
        );
    }

    public function handleListBookedUsers(array $payload): array
    {
        return $this->searchesBookings->listBookedUsers($payload['activity_id'], unserialize($payload['parameters']));
    }

    public function handleListActivitiesBooked(array $payload): array
    {
        return $this->searchesBookings->listActivitiesBooked($payload['user_id'], unserialize($payload['parameters']));
    }
}
