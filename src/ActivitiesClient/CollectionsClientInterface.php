<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface CollectionsClientInterface
{
    public function fetchCollection(string $collectionId): ApiResponseInterface;
    public function createCollection(array $data): ApiResponseInterface;
    public function listCollections(): ApiResponseInterface;
    public function deleteCollection(string $collectionId): ApiResponseInterface;
    public function updateCollection(string $collectionId, array $data): ApiResponseInterface;
}
