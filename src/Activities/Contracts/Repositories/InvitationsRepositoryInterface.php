<?php

namespace Deviate\Activities\Contracts\Repositories;

interface InvitationsRepositoryInterface
{
    public function inviteUserToActivity(int $userId, int $activityId): bool;
    public function updateToBooked(int $userId, int $activityId): bool;
    public function uninviteUserFromActivity(int $userId, int $activityId): bool;
    public function isUserInvitedToActivity(int $userId, int $activityId): bool;
    public function listInvitedUsers(int $activityId): array;
    public function listActivitiesInvitedTo(int $userId): array;
}
