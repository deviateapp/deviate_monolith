<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class InvitationsClient extends AbstractClient implements InvitationsClientInterface
{
    public function invite(string $userId, string $activityId): ApiResponseInterface
    {
        return $this->call('activities.invite', [
            'user_id'     => $userId,
            'activity_id' => $activityId,
        ]);
    }

    public function uninvite(string $userId, string $activityId): ApiResponseInterface
    {
        return $this->call('activities.uninvite', [
            'user_id'     => $userId,
            'activity_id' => $activityId,
        ]);
    }
}
