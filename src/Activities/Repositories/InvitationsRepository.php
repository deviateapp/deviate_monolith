<?php

namespace Deviate\Activities\Repositories;

use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Shared\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class InvitationsRepository extends AbstractRepository implements InvitationsRepositoryInterface
{
    public function inviteUserToActivity(string $userId, string $activityId): bool
    {
        return (bool) DB::table('activity_user')->insert([
            'activity_id' => $this->decode($activityId),
            'user_id'     => $this->decode($userId),
            'status'      => 'invited',
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function updateToBooked(string $userId, string $activityId): bool
    {
        return (bool) DB::table('activity_user')->where([
            'user_id'     => $this->decode($userId),
            'activity_id' => $this->decode($activityId),
        ])->update([
            'status'     => 'booked',
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function uninviteUserFromActivity(string $userId, string $activityId): bool
    {
        return (bool) DB::table('activity_user')->where([
            'activity_id' => $this->decode($activityId),
            'user_id'     => $this->decode($userId),
            'status'      => 'invited',
        ])->delete();
    }

    public function isUserInvitedToActivity(string $userId, string $activityId): bool
    {
        return DB::table('activity_user')->where([
            'activity_id' => $this->decode($activityId),
            'user_id'     => $this->decode($userId),
            'status'      => 'invited',
        ])->exists();
    }

    public function listInvitedUsers(string $activityId): array
    {
        return DB::table('activity_user')->where([
            'activity_id' => $this->decode($activityId),
            'status'      => 'invited',
        ])->pluck('user_id')->toArray();
    }

    public function listActivitiesInvitedTo(string $userId): array
    {
        return DB::table('activity_user')->where([
            'activity_id' => $this->decode($userId),
            'status'      => 'invited',
        ])->pluck('activity_id')->toArray();
    }
}
