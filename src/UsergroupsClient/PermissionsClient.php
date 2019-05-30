<?php

namespace Deviate\Usergroups\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class PermissionsClient extends AbstractClient implements PermissionsClientInterface
{
    public function sections(bool $withPermissions = true): ApiResponseInterface
    {
        return $this->call('permissions.list', [
            'include_permissions' => $withPermissions,
        ]);
    }

    public function listPermissionsInUsergroup(int $usergroupId): ApiResponseInterface
    {
        return $this->call('permissions.list.for_usergroup_id', [
            'id' => $usergroupId,
        ]);
    }
}
