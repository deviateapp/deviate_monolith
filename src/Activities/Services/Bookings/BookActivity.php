<?php

namespace Deviate\Activities\Services\Bookings;

use Deviate\Activities\Domain\BookingPreconditions\BookingPreconditionChecker;
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
        BookingPreconditionChecker $preconditionChecker
    ) {
        $this->bookingsRepository = $bookingsRepository;
        $this->fetchesUsers       = $fetchesUsers;
        $this->fetchesActivities  = $fetchesActivities;

        $this->preconditionChecker = $preconditionChecker;
    }

    public function bookUserOnActivity(int $userId, int $activityId, bool $force = false): void
    {
        $user     = $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $activity = $this->fetchesActivities->fetchById($activityId)->rethrow();

        $this->preconditionChecker->run($user->get('id'), $activity->get('id'), $force);

        $this->bookingsRepository->bookUserOnActivity($userId, $activityId);
    }

    public function canBookUserOnActivity(int $userId, int $activityId, bool $force): array
    {
        $user     = $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $activity = $this->fetchesActivities->fetchById($activityId)->rethrow();

        $result = $this->preconditionChecker->check($user->get('id'), $activity->get('id'), $force);

        return [
            'can_book' => count($result) === 0,
            'reasons'  => $result,
        ];
    }
}
