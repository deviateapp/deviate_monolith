<?php

namespace Deviate\Activities\Contracts\Services\Bookings;

interface UnbookActivityInterface
{
    public function unbookUserFromActivity(string $userId, string $activityId, bool $force = false): void;
}
