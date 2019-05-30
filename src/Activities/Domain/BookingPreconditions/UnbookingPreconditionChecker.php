<?php

namespace Deviate\Activities\Domain\BookingPreconditions;

class UnbookingPreconditionChecker
{
    private $preconditions = [];

    public function __construct(BookingMustBeOpen $bookingMustBeOpen)
    {
        $this->preconditions = [
            $bookingMustBeOpen,
        ];
    }

    public function run(string $userId, string $activityId, bool $force = false): void
    {
        foreach ($this->preconditions as $precondition) {
            $precondition->check($userId, $activityId, $force);
        }
    }
}
