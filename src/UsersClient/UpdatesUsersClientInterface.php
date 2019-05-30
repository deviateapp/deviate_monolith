<?php

namespace Deviate\Users\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface UpdatesUsersClientInterface
{
    public function updatePassword(int $userId, string $password): ApiResponseInterface;
    public function updateRememberToken(int $userId, ?string $token): ApiResponseInterface;
    public function updateCoreDetails(int $userId, array $data): ApiResponseInterface;
    public function deactivateUser(int $userId): ApiResponseInterface;
    public function reactivateUser(int $userId): ApiResponseInterface;
}
