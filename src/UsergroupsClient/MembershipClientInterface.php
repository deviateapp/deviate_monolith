<?php

namespace Deviate\Usergroups\Client;

use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

interface MembershipClientInterface
{
    public function join(int $userId, int $usergroupId): ApiResponseInterface;
    public function remove(int $userId, int $usergroupId): ApiResponseInterface;
    public function removeByUserId(int $userId): ApiResponseInterface;
    public function removeByUsergroupId(int $usergroupId): ApiResponseInterface;
    public function listMembers(int $usergroupId, ?SearchContainerInterface $search): ApiPaginatedResponseInterface;
}
