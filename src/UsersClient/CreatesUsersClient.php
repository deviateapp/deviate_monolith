<?php

declare(strict_types=1);

namespace Deviate\Users\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class CreatesUsersClient extends AbstractClient implements CreatesUsersClientInterface
{
    public function createUser(array $data): ApiResponseInterface
    {
        return $this->call('users.create', $data);
    }
}
