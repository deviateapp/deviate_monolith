<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface InvitationsClientInterface
{
    public function invite(string $userId, string $activityId): ApiResponseInterface;
    public function uninvite(string $userId, string $activityId): ApiResponseInterface;
}
