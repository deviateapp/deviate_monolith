<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface BookingsClientInterface
{
    public function book(int $userId, int $activityId, bool $force = false): ApiResponseInterface;
    public function unbook(int $userId, int $activityId, bool $force = false): ApiResponseInterface;
    public function canBook(int $userId, int $activityId, bool $force = false): ApiResponseInterface;
    public function canUnbook(int $userId, int $activityId, bool $force = false): ApiResponseInterface;
}
