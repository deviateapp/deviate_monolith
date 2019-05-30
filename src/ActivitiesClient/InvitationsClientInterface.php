<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface InvitationsClientInterface
{
    public function invite(int $userId, int $activityId): ApiResponseInterface;
    public function uninvite(int $userId, int $activityId): ApiResponseInterface;
}
