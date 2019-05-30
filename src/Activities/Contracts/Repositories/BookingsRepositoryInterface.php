<?php

namespace Deviate\Activities\Contracts\Repositories;

interface BookingsRepositoryInterface
{
    public function bookUserOnActivity(int $userId, int $activityId): bool;
    public function unbookUserFromActivity(int $userId, int $activityId): bool;
    public function isUserBookedOnActivity(int $userId, int $activityId): bool;
    public function listBookedUsers(int $activityId): array;
    public function listBookedActivities(int $userId): array;
    public function isFreeForActivity(int $userId, int $activityId): bool;
}
