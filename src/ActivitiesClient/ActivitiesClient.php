<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class ActivitiesClient extends AbstractClient implements ActivitiesClientInterface
{
    public function fetchById(string $activityId): ApiResponseInterface
    {
        return $this->call('activities.fetch_by_id', [
            'id' => $activityId,
        ]);
    }

    public function create(string $collectionId, array $data): ApiResponseInterface
    {
        return $this->call('activities.create', array_merge($data, [
            'activity_collection_id' => $collectionId,
        ]));
    }

    public function updateDetails(string $activityId, array $data): ApiResponseInterface
    {
        return $this->call('activities.update.by_id', array_merge($data, [
            'id' => $activityId,
        ]));
    }

    public function delete(string $activityId): ApiResponseInterface
    {
        return $this->call('activities.delete.by_id', [
            'id' => $activityId,
        ]);
    }
}
