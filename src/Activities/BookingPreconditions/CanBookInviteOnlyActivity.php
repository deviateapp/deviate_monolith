<?php

namespace Deviate\Activities\BookingPreconditions;

use Deviate\Activities\Client\ActivitiesClientInterface;
use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Activities\Exceptions\CannotBookInviteOnlyActivityException;

class CanBookInviteOnlyActivity implements PreconditionInterface
{
    private $invitationsRepository;
    private $fetchesActivities;

    public function __construct(
        InvitationsRepositoryInterface $invitationsRepository,
        ActivitiesClientInterface $fetchesActivities
    ) {
        $this->invitationsRepository = $invitationsRepository;
        $this->fetchesActivities     = $fetchesActivities;
    }

    public function check(string $userId, string $activityId, bool $force = false): void
    {
        $activity = $this->fetchesActivities->fetchById($activityId);

        $passes = !$activity->get('is_invite_only')
            || $this->invitationsRepository->isUserInvitedToActivity($userId, $activityId);

        if (!$passes) {
            $this->throwException();
        }
    }

    public function throwException(): void
    {
        throw new CannotBookInviteOnlyActivityException;
    }
}
