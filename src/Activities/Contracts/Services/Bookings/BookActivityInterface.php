<?php

namespace Deviate\Activities\Contracts\Services\Bookings;

interface BookActivityInterface
{
    public function bookUserOnActivity(int $userId, int $activityId, bool $force): void;
    public function canBookUserOnActivity(int $userId, int $activityId, bool $force): array;
}
