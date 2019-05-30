<?php

namespace Deviate\Activities\BookingPreconditions;

use Deviate\Activities\Contracts\Repositories\BookingsRepositoryInterface;
use Deviate\Activities\Exceptions\UserAlreadyBookedOnActivityException;

class UserNotAlreadyBooked implements PreconditionInterface
{
    private $bookingsRepository;

    public function __construct(BookingsRepositoryInterface $bookingsRepository)
    {
        $this->bookingsRepository = $bookingsRepository;
    }

    public function check(string $userId, string $activityId, bool $force = false): void
    {
        $passes = !$this->bookingsRepository->isUserBookedOnActivity($userId, $activityId);

        if (!$passes) {
            $this->throwException();
        }
    }

    public function throwException(): void
    {
        throw new UserAlreadyBookedOnActivityException;
    }
}
