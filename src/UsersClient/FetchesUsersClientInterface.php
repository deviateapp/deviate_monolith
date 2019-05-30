<?php

namespace Deviate\Users\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface FetchesUsersClientInterface
{
    public function fetchUserById(string $id): ApiResponseInterface;
    public function fetchUserByRememberToken(string $organisationId, string $token): ApiResponseInterface;
}
