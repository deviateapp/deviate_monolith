<?php

namespace Deviate\Users\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface DeletesUsersClientInterface
{
    public function deleteUser(int $userId): ApiResponseInterface;
}
