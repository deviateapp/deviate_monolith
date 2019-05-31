<?php

namespace Deviate\Activities\Services\Bookings;

use Deviate\Activities\Client\ActivitiesClientInterface;
use Deviate\Activities\Contracts\Repositories\BookingsRepositoryInterface;
use Deviate\Activities\Contracts\Services\Bookings\UnbookActivityInterface;
use Deviate\Activities\Domain\BookingPreconditions\UnbookingPreconditionChecker;
use Deviate\Users\Client\FetchesUsersClientInterface;

class UnbookActivity implements UnbookActivityInterface
{
    private $bookingsRepository;
    private $fetchesUsers;
    private $fetchesActivities;
    private $preconditionChecker;

    public function __construct(
        BookingsRepositoryInterface $bookingsRepository,
        FetchesUsersClientInterface $fetchesUsers,
        ActivitiesClientInterface $fetchesActivities,
        UnbookingPreconditionChecker $preconditionChecker
    ) {
        $this->bookingsRepository         = $bookingsRepository;
        $this->fetchesUsers               = $fetchesUsers;
        $this->fetchesActivities          = $fetchesActivities;
        $this->preconditionChecker        = $preconditionChecker;
    }

    public function unbookUserFromActivity(int $userId, int $activityId, bool $force = false): void
    {
        $user     = $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $activity = $this->fetchesActivities->fetchById($activityId)->rethrow();

        $this->preconditionChecker->run($user->get('id'), $activity->get('id'), $force);

        $this->bookingsRepository->unbookUserFromActivity($userId, $activityId);
    }

    public function canUnbookUserFromActivity(int $userId, int $activityId, bool $force = false): array
    {
        $user     = $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $activity = $this->fetchesActivities->fetchById($activityId)->rethrow();

        $result = $this->preconditionChecker->check($user->get('id'), $activity->get('id'), $force);

        return [
            'can_unbook' => count($result) === 0,
            'reasons'    => $result,
        ];
    }
}
