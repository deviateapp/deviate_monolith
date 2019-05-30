<?php

namespace Deviate\Users\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface CreatesUsersClientInterface
{
    public function createUser(array $data): ApiResponseInterface;
}
