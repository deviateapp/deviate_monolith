<?php

namespace Deviate\Activities\Services\Invitations;

use Deviate\Activities\Contracts\Repositories\ActivitiesRepositoryInterface;
use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Activities\Contracts\Services\Invitations\SearchInvitationsInterface;
use Deviate\Shared\Search\Filters\MustBeIn;
use Deviate\Shared\Search\SearchContainerInterface;
use Deviate\Users\Client\FetchesUsersClientInterface;
use Deviate\Users\Client\SearchClientInterface;

class SearchInvitations implements SearchInvitationsInterface
{
    private $fetchesActivities;
    private $invitationsRepository;
    private $searchesUsers;

    public function __construct(
        ActivitiesRepositoryInterface $fetchesActivities,
        InvitationsRepositoryInterface $invitationsRepository,
        SearchClientInterface $searchesUsers
    ) {
        $this->fetchesActivities     = $fetchesActivities;
        $this->invitationsRepository = $invitationsRepository;
        $this->searchesUsers         = $searchesUsers;
    }

    public function listInvites(int $activityId, SearchContainerInterface $search): array
    {
        $this->fetchesActivities->fetchById($activityId);

        $invites = $this->invitationsRepository->listInvitedUsers($activityId);

        $search->addFilter(new MustBeIn('id', $invites));

        return $this->searchesUsers->search($search)->toArray();
    }
}
