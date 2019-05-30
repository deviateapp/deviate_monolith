<?php

namespace Deviate\Activities\Repositories;

use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Activities\Models\Eloquent\Invitation;
use Deviate\Shared\Repositories\AbstractRepository;

class InvitationsRepository extends AbstractRepository implements InvitationsRepositoryInterface
{
    private $invitation;

    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function inviteUserToActivity(int $userId, int $activityId): bool
    {
        return (bool) $this->invitation->newQuery()->create([
            'activity_id' => $activityId,
            'user_id'     => $userId,
        ]);
    }

    public function updateToBooked(int $userId, int $activityId): bool
    {
        return (bool) $this->invitation->newQuery()
            ->for($userId, $activityId)
            ->firstOrFail()
            ->update([
                'status' => 'booked',
            ]);
    }

    public function uninviteUserFromActivity(int $userId, int $activityId): bool
    {
        return $this->invitation->newQuery()->for($userId, $activityId)->delete();
    }

    public function isUserInvitedToActivity(int $userId, int $activityId): bool
    {
        return $this->invitation->newQuery()->for($userId, $activityId)->exists();
    }

    public function listInvitedUsers(int $activityId): array
    {
        return $this->invitation->newQuery()
            ->where('activity_id', $activityId)
            ->pluck('user_id')
            ->toArray();
    }

    public function listActivitiesInvitedTo(int $userId): array
    {
        return $this->invitation->newQuery()
            ->where('user_id', $userId)
            ->pluck('activity_id')
            ->toArray();
    }
}
