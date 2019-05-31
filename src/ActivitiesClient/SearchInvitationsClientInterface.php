<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

interface SearchInvitationsClientInterface
{
    public function listInvitedUsers(
        int $activityId,
        SearchContainerInterface $search
    ): ApiPaginatedResponseInterface;

    public function listInvitedActivities(
        int $userId,
        SearchContainerInterface $search
    ): ApiPaginatedResponseInterface;
}
