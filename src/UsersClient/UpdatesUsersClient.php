<?php

declare(strict_types=1);

namespace Deviate\Users\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class UpdatesUsersClient extends AbstractClient implements UpdatesUsersClientInterface
{
    public function updatePassword(int $userId, string $password): ApiResponseInterface
    {
        return $this->call('users.update.password', [
            'id'       => $userId,
            'password' => $password,
        ]);
    }

    public function updateRememberToken(int $userId, ?string $token): ApiResponseInterface
    {
        return $this->call('users.update.remember_token', [
            'id'    => $userId,
            'token' => $token,
        ]);
    }

    public function updateCoreDetails(int $userId, array $data): ApiResponseInterface
    {
        return $this->call('users.update.core_details', array_merge($data, [
            'id' => $userId,
        ]));
    }

    public function deactivateUser(int $userId): ApiResponseInterface
    {
        return $this->call('users.authentication.modify_activation', [
            'id'     => $userId,
            'active' => false,
        ]);
    }

    public function reactivateUser(int $userId): ApiResponseInterface
    {
        return $this->call('users.authentication.modify_activation', [
            'id'     => $userId,
            'active' => true,
        ]);
    }
}
