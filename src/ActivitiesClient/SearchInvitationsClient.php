<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Exceptions\AbstractApiException;
use Deviate\Shared\Responses\Clients\ApiPaginatedErrorResponse;
use Deviate\Shared\Responses\Clients\ApiPaginatedResponse;
use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

class SearchInvitationsClient extends AbstractClient implements SearchInvitationsClientInterface
{
    public function listInvitedUsers(
        int $activityId,
        SearchContainerInterface $search
    ): ApiPaginatedResponseInterface {
        return $this->call('activities.invitations.search.invited', [
            'activity_id' => $activityId,
            'parameters'  => serialize($search),
        ]);
    }

    public function listInvitedActivities(
        int $userId,
        SearchContainerInterface $search
    ): ApiPaginatedResponseInterface {
        return $this->call('activities.invitations.search.invitations_for_user', [
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
