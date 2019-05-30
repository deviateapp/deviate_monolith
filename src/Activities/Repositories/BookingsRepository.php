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

    public function bookUserOnActivity(string $userId, string $activityId): bool
    {
        if ($this->invitationsRepository->isUserInvitedToActivity($userId, $activityId)) {
            return $this->invitationsRepository->updateToBooked($userId, $activityId);
        }

        $this->booking->newQuery()->create([
            'activity_id' => $activityId,
            'user_id'     => $userId,
        ]);

        return true;
    }

    public function unbookUserFromActivity(string $userId, string $activityId): bool
    {
        return $this->booking->newQuery()->where([
            'user_id'     => $userId,
            'activity_id' => $activityId,
        ])->delete();
    }

    public function isUserBookedOnActivity(string $userId, string $activityId): bool
    {
        return $this->booking->newQuery()->where([
            'activity_id' => $activityId,
            'user_id'     => $userId,
        ])->exists();
    }

    public function listBookedUsers(string $activityId): array
    {
        return $this->booking->newQuery()
            ->where('activity_id', $activityId)
            ->pluck('user_id')
            ->toArray();
    }

    public function listBookedActivities(string $userId): array
    {
        return $this->booking->newQuery()
            ->where('user_id', $userId)
            ->pluck('activity_id')
            ->toArray();
    }

    public function isFreeForActivity(string $userId, string $activityId): bool
    {
        $activity = $this->activitiesRepository->fetchById($activityId);

        return $this->booking->newQuery()
            ->where('user_id', $userId)
            ->where('activity_id', '!=', $activityId)
            ->activityOverlaps($activity)
            ->doesntExist();
    }
}
