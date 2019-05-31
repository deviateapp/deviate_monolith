<?php

namespace Deviate\Activities\Domain\BookingPreconditions;

use Exception;

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
