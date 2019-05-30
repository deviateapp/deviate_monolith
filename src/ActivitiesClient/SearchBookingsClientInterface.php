<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

interface SearchBookingsClientInterface
{
    public function listBookedUsers(
        string $activityId,
        SearchContainerInterface $search
    ): ApiPaginatedResponseInterface;

    public function listBookedActivities(
        string $userId,
        SearchContainerInterface $search
    ): ApiPaginatedResponseInterface;
}
