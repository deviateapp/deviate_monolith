<?php

namespace Deviate\Usergroups\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class UsergroupsClient extends AbstractClient implements UsergroupsClientInterface
{
    public function fetchUsergroup(string $id): ApiResponseInterface
    {
        return $this->call('usergroups.fetch.by_id', [
            'id' => $id,
        ]);
    }

    public function createUsergroup(array $data): ApiResponseInterface
    {
        return $this->call('usergroups.create', $data);
    }

    public function updateUsergroup(string $id, array $data): ApiResponseInterface
    {
        return $this->call('usergroups.update', array_merge($data, [
            'id' => $id,
        ]));
    }

    public function deleteUsergroup(string $id): ApiResponseInterface
    {
        return $this->call('usergroups.delete', [
            'id' => $id,
        ]);
    }

    public function applyPermissions(string $usergroupId, array $permissions): ApiResponseInterface
    {
        return $this->call('usergroups.set_permissions', [
            'id'          => $usergroupId,
            'permissions' => $permissions,
        ]);
    }
}
