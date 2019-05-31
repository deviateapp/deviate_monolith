<?php

namespace Deviate\Activities\Services\Invitations;

use Deviate\Activities\Client\ActivitiesClientInterface;
use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Activities\Contracts\Services\Invitations\UninviteUserInterface;
use Deviate\Activities\Domain\BookingPreconditions\UninvitePreconditionChecker;
use Deviate\Users\Client\FetchesUsersClientInterface;

class UninviteUser implements UninviteUserInterface
{
    private $invitationRepository;
    private $fetchesUsers;
    private $fetchesActivities;
    private $preconditionChecker;

    public function __construct(
        InvitationsRepositoryInterface $invitationRepository,
        FetchesUsersClientInterface $fetchesUsers,
        ActivitiesClientInterface $fetchesActivities,
        UninvitePreconditionChecker $preconditionChecker
    ) {
        $this->invitationRepository = $invitationRepository;
        $this->fetchesUsers         = $fetchesUsers;
        $this->fetchesActivities    = $fetchesActivities;
        $this->preconditionChecker  = $preconditionChecker;
    }

    public function uninviteUserFromActivity(int $userId, int $activityId): void
    {
        $user     = $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $activity = $this->fetchesActivities->fetchById($activityId)->rethrow();

        $this->preconditionChecker->run($user->get('id'), $activity->get('id'), false);

        $this->invitationRepository->uninviteUserFromActivity($userId, $activityId);
    }
}
