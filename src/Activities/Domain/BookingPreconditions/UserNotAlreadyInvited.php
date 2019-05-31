<?php

namespace Deviate\Activities\Domain\BookingPreconditions;

use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Activities\Exceptions\UserAlreadyInvitedToActivityException;

class UserNotAlreadyInvited implements PreconditionInterface
{
    private $invitationsRepository;

    public function __construct(InvitationsRepositoryInterface $invitationsRepository)
    {
        $this->invitationsRepository = $invitationsRepository;
    }

    public function check(string $userId, string $activityId, bool $force = false): void
    {
        $passes = !$this->invitationsRepository->isUserInvitedToActivity($userId, $activityId);

        if (!$passes) {
            $this->throwException();
        }
    }

    public function throwException(): void
    {
        throw new UserAlreadyInvitedToActivityException;
    }
}
