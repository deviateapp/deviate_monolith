<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

interface SearchBookingsClientInterface
{
    public function listBookedUsers(
        int $activityId,
        SearchContainerInterface $search
    ): ApiPaginatedResponseInterface;

    public function listBookedActivities(
        int $userId,
        SearchContainerInterface $search
    ): ApiPaginatedResponseInterface;
}
