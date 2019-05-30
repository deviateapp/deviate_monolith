<?php

namespace Deviate\Usergroups\Client;

use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

interface MembershipClientInterface
{
    public function join(string $userId, string $usergroupId): ApiResponseInterface;
    public function remove(string $userId, string $usergroupId): ApiResponseInterface;
    public function removeByUserId(string $userId): ApiResponseInterface;
    public function removeByUsergroupId(string $usergroupId): ApiResponseInterface;
    public function listMembers(string $usergroupId, ?SearchContainerInterface $search): ApiPaginatedResponseInterface;
}
