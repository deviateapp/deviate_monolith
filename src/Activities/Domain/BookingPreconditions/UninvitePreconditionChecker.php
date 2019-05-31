<?php

namespace Deviate\Activities\Domain\BookingPreconditions;

class UninvitePreconditionChecker
{
    private $preconditions = [];

    public function __construct(
        UserMustBeInvited $userMustBeInvited
    ) {
        $this->preconditions = [
            $userMustBeInvited,
        ];
    }

    public function run(string $userId, string $activityId, bool $force = false): void
    {
        foreach ($this->preconditions as $precondition) {
            $precondition->check($userId, $activityId, $force);
        }
    }
}
