<?php

namespace Deviate\Activities\Contracts\Repositories;

interface BookingsRepositoryInterface
{
    public function bookUserOnActivity(string $userId, string $activityId): bool;
    public function unbookUserFromActivity(string $userId, string $activityId): bool;
    public function isUserBookedOnActivity(string $userId, string $activityId): bool;
    public function listBookedUsers(string $activityId): array;
    public function listBookedActivities(string $userId): array;
    public function isFreeForActivity(string $userId, string $activityId): bool;
}
