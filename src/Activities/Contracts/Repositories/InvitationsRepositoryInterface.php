<?php

namespace Deviate\Activities\Contracts\Repositories;

interface InvitationsRepositoryInterface
{
    public function inviteUserToActivity(string $userId, string $activityId): bool;
    public function updateToBooked(string $userId, string $activityId): bool;
    public function uninviteUserFromActivity(string $userId, string $activityId): bool;
    public function isUserInvitedToActivity(string $userId, string $activityId): bool;
    public function listInvitedUsers(string $activityId): array;
    public function listActivitiesInvitedTo(string $userId): array;
}
