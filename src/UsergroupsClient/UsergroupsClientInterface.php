<?php

namespace Deviate\Usergroups\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface UsergroupsClientInterface
{
    public function fetchUsergroup(int $id): ApiResponseInterface;
    public function createUsergroup(array $data): ApiResponseInterface;
    public function updateUsergroup(int $id, array $data): ApiResponseInterface;
    public function deleteUsergroup(int $id): ApiResponseInterface;

    public function applyPermissions(int $usergroupId, array $permissions): ApiResponseInterface;
}
