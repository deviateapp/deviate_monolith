<?php

namespace Deviate\Activities\Services\Bookings;

use Deviate\Activities\BookingPreconditions\PreconditionChecker;
use Deviate\Activities\Client\ActivitiesClientInterface;
use Deviate\Activities\Contracts\Repositories\BookingsRepositoryInterface;
use Deviate\Activities\Contracts\Services\Bookings\BookActivityInterface;
use Deviate\Users\Client\FetchesUsersClientInterface;

class BookActivity implements BookActivityInterface
{
    private $bookingsRepository;
    private $fetchesUsers;
    private $fetchesActivities;
    private $preconditionChecker;

    public function __construct(
        BookingsRepositoryInterface $bookingsRepository,
        FetchesUsersClientInterface $fetchesUsers,
        ActivitiesClientInterface $fetchesActivities,
        PreconditionChecker $preconditionChecker
    ) {
        $this->bookingsRepository         = $bookingsRepository;
        $this->fetchesUsers               = $fetchesUsers;
        $this->fetchesActivities          = $fetchesActivities;

        $this->preconditionChecker = $preconditionChecker;
    }

    public function bookUserOnActivity(int $userId, int $activityId, bool $force = false): void
    {
        $user     = $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $activity = $this->fetchesActivities->fetchById($activityId)->rethrow();

        $this->preconditionChecker->run($user->get('id'), $activity->get('id'), $force);

        $this->bookingsRepository->bookUserOnActivity($userId, $activityId);
    }
}
