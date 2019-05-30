<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class CollectionsClient extends AbstractClient implements CollectionsClientInterface
{
    public function fetchCollection(string $collectionId): ApiResponseInterface
    {
        return $this->call('activities.collections.fetch_by_id', [
            'id' => $collectionId,
        ]);
    }

    public function createCollection(array $data): ApiResponseInterface
    {
        return $this->call('activities.collections.create', $data);
    }

    public function listCollections(): ApiResponseInterface
    {
        return $this->call('activities.collections.list');
    }

    public function deleteCollection(string $collectionId): ApiResponseInterface
    {
        return $this->call('activities.collections.delete_by_id', [
            'id' => $collectionId,
        ]);
    }

    public function updateCollection(string $collectionId, array $data): ApiResponseInterface
    {
        return $this->call('activities.collections.update', array_merge($data, [
            'id' => $collectionId,
        ]));
    }
}
