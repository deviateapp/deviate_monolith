<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface CollectionsClientInterface
{
    public function fetchCollection(int $collectionId): ApiResponseInterface;
    public function createCollection(array $data): ApiResponseInterface;
    public function listCollections(): ApiResponseInterface;
    public function deleteCollection(int $collectionId): ApiResponseInterface;
    public function updateCollection(int $collectionId, array $data): ApiResponseInterface;
}
