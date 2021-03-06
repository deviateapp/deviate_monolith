<?php

namespace Deviate\Activities\Services\Invitations;

use Deviate\Activities\Client\ActivitiesClientInterface;
use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Activities\Contracts\Services\Invitations\InviteUserInterface;
use Deviate\Activities\Domain\BookingPreconditions\InvitePreconditionChecker;
use Deviate\Users\Client\FetchesUsersClientInterface;

class InviteUser implements InviteUserInterface
{
    private $invitationRepository;
    private $fetchesUsers;
    private $fetchesActivities;
    private $preconditionChecker;

    public function __construct(
        InvitationsRepositoryInterface $invitationRepository,
        FetchesUsersClientInterface $fetchesUsers,
        ActivitiesClientInterface $fetchesActivities,
        InvitePreconditionChecker $preconditionChecker
    ) {
        $this->invitationRepository = $invitationRepository;
        $this->fetchesUsers         = $fetchesUsers;
        $this->fetchesActivities    = $fetchesActivities;
        $this->preconditionChecker  = $preconditionChecker;
    }

    public function inviteUserToActivity(int $userId, int $activityId): void
    {
        $user     = $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $activity = $this->fetchesActivities->fetchById($activityId)->rethrow();

        $this->preconditionChecker->run($user->get('id'), $activity->get('id'), false);

        $this->invitationRepository->inviteUserToActivity($userId, $activityId);
    }
}
