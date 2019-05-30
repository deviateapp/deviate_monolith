<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface BookingsClientInterface
{
    public function book(string $userId, string $activityId, bool $force = false): ApiResponseInterface;
    public function unbook(string $userId, string $activityId, bool $force = false): ApiResponseInterface;
}
