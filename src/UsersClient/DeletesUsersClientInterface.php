<?php

namespace Deviate\Users\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface DeletesUsersClientInterface
{
    public function deleteUser(string $userId): ApiResponseInterface;
}
