<?php

namespace Deviate\Activities\Domain\BookingPreconditions;

class InvitePreconditionChecker
{
    private $preconditions = [];

    public function __construct(
        UserNotAlreadyInvited $userNotAlreadyInvited,
        UserNotAlreadyBooked $userNotAlreadyBooked
    ) {
        $this->preconditions = [
            $userNotAlreadyInvited,
            $userNotAlreadyBooked,
        ];
    }

    public function run(string $userId, string $activityId, bool $force = false): void
    {
        foreach ($this->preconditions as $precondition) {
            $precondition->check($userId, $activityId, $force);
        }
    }
}
