<?php

namespace Deviate\Users\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface AuthenticatesUsersClientInterface
{
    public function validatePassword(string $userId, string $password): ApiResponseInterface;
}
