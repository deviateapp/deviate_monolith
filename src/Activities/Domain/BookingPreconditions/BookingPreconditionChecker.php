<?php

namespace Deviate\Activities\Domain\BookingPreconditions;

use Exception;

class BookingPreconditionChecker
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

    public function run(int $userId, int $activityId, bool $force = false): void
    {
        foreach ($this->preconditions as $precondition) {
            $precondition->check($userId, $activityId, $force);
        }
    }

    public function check(int $userId, int $activityId, bool $force = false): array
    {
        $reasons = [];

        foreach ($this->preconditions as $precondition) {
            try {
                $precondition->check($userId, $activityId, $force);
            } catch (Exception $preconditionException) {
                $reasons[] = $preconditionException->getMessage();
            }
        }

        return $reasons;
    }
}
