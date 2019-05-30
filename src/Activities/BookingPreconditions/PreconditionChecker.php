<?php

namespace Deviate\Activities\BookingPreconditions;

class PreconditionChecker
{
    private $preconditions = [];

    public function __construct(
        BookingMustBeOpen $bookingMustBeOpen,
        UserNotAlreadyBooked $userNotAlreadyBooked,
        UserIsAvailable $userIsAvailable,
        CanBookInviteOnlyActivity $canBookInviteOnlyActivity
    ) {
        $this->preconditions = [
            $bookingMustBeOpen,
            $userNotAlreadyBooked,
            $userIsAvailable,
            $canBookInviteOnlyActivity,
        ];
    }

    public function run(string $userId, string $activityId, bool $force = false): void
    {
        foreach ($this->preconditions as $precondition) {
            $precondition->check($userId, $activityId, $force);
        }
    }
}
