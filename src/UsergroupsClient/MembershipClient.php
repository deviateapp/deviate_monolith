<?php

namespace Deviate\Usergroups\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiPaginatedResponse;
use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Deviate\Shared\Search\SearchContainer;
use Deviate\Shared\Search\SearchContainerInterface;

class MembershipClient extends AbstractClient implements MembershipClientInterface
{
    public function join(string $userId, string $usergroupId): ApiResponseInterface
    {
        return $this->call('usergroups.membership.join', [
            'user_id'      => $userId,
            'usergroup_id' => $usergroupId,
        ]);
    }

    public function remove(string $userId, string $usergroupId): ApiResponseInterface
    {
        return $this->call('usergroups.membership.remove', [
            'user_id'      => $userId,
            'usergroup_id' => $usergroupId,
        ]);
    }

    public function removeByUserId(string $userId): ApiResponseInterface
    {
        return $this->call('usergroups.membership.remove.user_id', [
            'id' => $userId,
        ]);
    }

    public function removeByUsergroupId(string $usergroupId): ApiResponseInterface
    {
        return $this->call('usergroups.membership.remove.usergroup_id', [
            'id' => $usergroupId,
        ]);
    }

    public function listMembers(string $usergroupId, ?SearchContainerInterface $search): ApiPaginatedResponseInterface
    {
        $search = $search ?? new SearchContainer;

        $response = $this->call('usergroups.membership.search_members', [
            'id'         => $usergroupId,
            'parameters' => serialize($search),
        ]);

        return new ApiPaginatedResponse($response->toArray());
    }
}
