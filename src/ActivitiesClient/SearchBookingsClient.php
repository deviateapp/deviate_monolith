<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Exceptions\AbstractApiException;
use Deviate\Shared\Responses\Clients\ApiPaginatedErrorResponse;
use Deviate\Shared\Responses\Clients\ApiPaginatedResponse;
use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

class SearchBookingsClient extends AbstractClient implements SearchBookingsClientInterface
{
    public function listBookedUsers(
        string $activityId,
        SearchContainerInterface $search
    ): ApiPaginatedResponseInterface {
        return $this->call('activities.bookings.search.users_on_activity', [
            'activity_id' => $activityId,
            'parameters'  => serialize($search),
        ]);
    }

    public function listBookedActivities(
        string $userId,
        SearchContainerInterface $search
    ): ApiPaginatedResponseInterface {
        return $this->call('activities.bookings.search.activities_for_user', [
            'user_id'    => $userId,
            'parameters' => serialize($search),
        ]);
    }

    protected function toApiResponse(?array $response): ApiResponseInterface
    {
        return new ApiPaginatedResponse($response);
    }

    protected function toApiErrorResponse(AbstractApiException $exception)
    {
        return new ApiPaginatedErrorResponse($exception);
    }
}
