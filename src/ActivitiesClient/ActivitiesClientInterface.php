<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface ActivitiesClientInterface
{
    public function fetchById(string $activityId): ApiResponseInterface;
    public function create(string $collectionId, array $data): ApiResponseInterface;
    public function updateDetails(string $activityId, array $data): ApiResponseInterface;
    public function delete(string $activityId): ApiResponseInterface;
}
