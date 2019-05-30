<?php

namespace Deviate\Users\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface FetchesUsersClientInterface
{
    public function fetchUserById(int $id): ApiResponseInterface;
    public function fetchUserByRememberToken(int $organisationId, string $token): ApiResponseInterface;
}
