<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface ActivitiesClientInterface
{
    public function fetchById(int $activityId): ApiResponseInterface;
    public function create(int $collectionId, array $data): ApiResponseInterface;
    public function updateDetails(int $activityId, array $data): ApiResponseInterface;
    public function delete(int $activityId): ApiResponseInterface;
}
