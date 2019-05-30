<?php

namespace Deviate\Activities\Services\Invitations;

use Deviate\Activities\Client\ActivitiesClientInterface;
use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Activities\Contracts\Services\Invitations\InviteUserInterface;
use Deviate\Activities\Exceptions\UserAlreadyInvitedToActivityException;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Deviate\Users\Client\FetchesUsersClientInterface;

class InviteUser implements InviteUserInterface
{
    private $invitationRepository;
    private $fetchesUsers;
    private $fetchesActivities;

    public function __construct(
        InvitationsRepositoryInterface $invitationRepository,
        FetchesUsersClientInterface $fetchesUsers,
        ActivitiesClientInterface $fetchesActivities
    ) {
        $this->invitationRepository = $invitationRepository;
        $this->fetchesUsers         = $fetchesUsers;
        $this->fetchesActivities    = $fetchesActivities;
    }

    public function inviteUserToActivity(int $userId, int $activityId): void
    {
        $user     = $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $activity = $this->fetchesActivities->fetchById($activityId)->rethrow();

        if ($this->userAlreadyInvited($user, $activity)) {
            throw new UserAlreadyInvitedToActivityException;
        }

        $this->invitationRepository->inviteUserToActivity($userId, $activityId);
    }

    public function userAlreadyInvited(ApiResponseInterface $user, ApiResponseInterface $activity)
    {
        return $this->invitationRepository->isUserInvitedToActivity($user->get('id'), $activity->get('id'));
    }
}
