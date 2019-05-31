<?php

namespace Deviate\Activities\Services\Invitations;

use Deviate\Activities\Contracts\Repositories\ActivitiesRepositoryInterface;
use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Activities\Contracts\Services\Invitations\SearchInvitationsInterface;
use Deviate\Shared\Search\Filters\MustBeIn;
use Deviate\Shared\Search\SearchContainerInterface;
use Deviate\Users\Client\FetchesUsersClientInterface;
use Deviate\Users\Client\SearchClientInterface as SearchUsersClientInterface;
use Deviate\Activities\Client\SearchClientInterface as SearchActivitiesClientInterface;

class SearchInvitations implements SearchInvitationsInterface
{
    private $fetchesActivities;
    private $invitationsRepository;
    private $fetchesUsers;
    private $searchesUsers;
    private $searchesActivities;

    public function __construct(
        ActivitiesRepositoryInterface $fetchesActivities,
        InvitationsRepositoryInterface $invitationsRepository,
        FetchesUsersClientInterface $fetchesUsers,
        SearchUsersClientInterface $searchesUsers,
        SearchActivitiesClientInterface $searchesActivities
    ) {
        $this->fetchesActivities     = $fetchesActivities;
        $this->invitationsRepository = $invitationsRepository;
        $this->fetchesUsers          = $fetchesUsers;
        $this->searchesUsers         = $searchesUsers;
        $this->searchesActivities    = $searchesActivities;
    }

    public function listInvitedUsers(int $activityId, SearchContainerInterface $search): array
    {
        $this->fetchesActivities->fetchById($activityId);

        $invites = $this->invitationsRepository->listInvitedUsers($activityId);

        $search->addFilter(new MustBeIn('id', $invites));

        return $this->searchesUsers->search($search)->toArray();
    }

    public function listInvitedActivities(int $userId, SearchContainerInterface $search): array
    {
        $this->fetchesUsers->fetchUserById($userId)->rethrow();

        $invites = $this->invitationsRepository->listActivitiesInvitedTo($userId);

        $search->addFilter(new MustBeIn('id', $invites));

        return $this->searchesActivities->searchActivities($search)->toArray();
    }
}
