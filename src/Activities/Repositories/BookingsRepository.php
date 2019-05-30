<?php

namespace Deviate\Activities\Repositories;

use Deviate\Activities\Contracts\Repositories\ActivitiesRepositoryInterface;
use Deviate\Activities\Contracts\Repositories\BookingsRepositoryInterface;
use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Activities\Models\Eloquent\Booking;
use Deviate\Shared\Repositories\AbstractRepository;

class BookingsRepository extends AbstractRepository implements BookingsRepositoryInterface
{
    /** @var Booking */
    private $booking;

    /** @var ActivitiesRepositoryInterface */
    private $activitiesRepository;

    /** @var InvitationsRepositoryInterface */
    private $invitationsRepository;

    public function __construct(
        Booking $booking,
        ActivitiesRepositoryInterface $activitiesRepository,
        InvitationsRepositoryInterface $invitationsRepository
    ) {
        $this->booking               = $booking;
        $this->activitiesRepository  = $activitiesRepository;
        $this->invitationsRepository = $invitationsRepository;
    }

    public function bookUserOnActivity(int $userId, int $activityId): bool
    {
        if ($this->invitationsRepository->isUserInvitedToActivity($userId, $activityId)) {
            return $this->invitationsRepository->updateToBooked($userId, $activityId);
        }

        return (bool) $this->booking->newQuery()->create([
            'activity_id' => $activityId,
            'user_id'     => $userId,
        ]);
    }

    public function unbookUserFromActivity(int $userId, int $activityId): bool
    {
        return $this->booking->newQuery()->for($userId, $activityId)->delete();
    }

    public function isUserBookedOnActivity(int $userId, int $activityId): bool
    {
        return $this->booking->newQuery()->for($userId, $activityId)->exists();
    }

    public function listBookedUsers(int $activityId): array
    {
        return $this->booking->newQuery()
            ->where('activity_id', $activityId)
            ->pluck('user_id')
            ->toArray();
    }

    public function listBookedActivities(int $userId): array
    {
        return $this->booking->newQuery()
            ->where('user_id', $userId)
            ->pluck('activity_id')
            ->toArray();
    }

    public function isFreeForActivity(int $userId, int $activityId): bool
    {
        $activity = $this->activitiesRepository->fetchById($activityId);

        return $this->booking->newQuery()
            ->where('user_id', $userId)
            ->where('activity_id', '!=', $activityId)
            ->activityOverlaps($activity)
            ->doesntExist();
    }
}
