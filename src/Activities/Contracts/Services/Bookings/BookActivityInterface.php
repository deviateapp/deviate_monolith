<?php

namespace Deviate\Activities\Contracts\Services\Bookings;

interface BookActivityInterface
{
    public function bookUserOnActivity(string $userId, string $activityId, bool $force): void;
}
