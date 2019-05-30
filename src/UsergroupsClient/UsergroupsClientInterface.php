<?php

namespace Deviate\Usergroups\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface UsergroupsClientInterface
{
    public function fetchUsergroup(string $id): ApiResponseInterface;
    public function createUsergroup(array $data): ApiResponseInterface;
    public function updateUsergroup(string $id, array $data): ApiResponseInterface;
    public function deleteUsergroup(string $id): ApiResponseInterface;

    public function applyPermissions(string $usergroupId, array $permissions): ApiResponseInterface;
}
