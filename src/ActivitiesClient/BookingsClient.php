<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class BookingsClient extends AbstractClient implements BookingsClientInterface
{
    public function book(string $userId, string $activityId, bool $force = false): ApiResponseInterface
    {
        return $this->call('activities.book', [
            'user_id'       => $userId,
            'activity_id'   => $activityId,
            'force_booking' => $force,
        ]);
    }

    public function unbook(string $userId, string $activityId, bool $force = false): ApiResponseInterface
    {
        return $this->call('activities.unbook', [
            'user_id'         => $userId,
            'activity_id'     => $activityId,
            'force_unbooking' => $force,
        ]);
    }
}
