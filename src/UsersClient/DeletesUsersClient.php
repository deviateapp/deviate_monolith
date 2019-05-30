<?php

declare(strict_types=1);

namespace Deviate\Users\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class DeletesUsersClient extends AbstractClient implements DeletesUsersClientInterface
{
    public function deleteUser(string $userId): ApiResponseInterface
    {
        return $this->call('users.authentication.delete', [
            'id' => $userId,
        ]);
    }
}
