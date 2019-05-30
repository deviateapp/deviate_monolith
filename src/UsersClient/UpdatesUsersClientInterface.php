<?php

namespace Deviate\Users\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface UpdatesUsersClientInterface
{
    public function updatePassword(string $userId, string $password): ApiResponseInterface;
    public function updateRememberToken(string $userId, ?string $token): ApiResponseInterface;
    public function updateCoreDetails(string $userId, array $data): ApiResponseInterface;
    public function deactivateUser(string $userId): ApiResponseInterface;
    public function reactivateUser(string $userId): ApiResponseInterface;
}
