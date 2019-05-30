<?php

namespace Deviate\Activities\Contracts\Services\Bookings;

interface UnbookActivityInterface
{
    public function unbookUserFromActivity(int $userId, int $activityId, bool $force = false): void;
}
