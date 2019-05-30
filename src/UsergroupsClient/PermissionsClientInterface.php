<?php

namespace Deviate\Usergroups\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface PermissionsClientInterface
{
    public function sections(bool $withPermissions = true): ApiResponseInterface;
    public function listPermissionsInUsergroup(int $usergroupId): ApiResponseInterface;
}
