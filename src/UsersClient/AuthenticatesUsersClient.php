<?php

declare(strict_types=1);

namespace Deviate\Users\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class AuthenticatesUsersClient extends AbstractClient implements AuthenticatesUsersClientInterface
{
    public function validatePassword(string $userId, string $password): ApiResponseInterface
    {
        return $this->call('users.authentication.validate_password', [
            'id'       => $userId,
            'password' => $password,
        ]);
    }
}
