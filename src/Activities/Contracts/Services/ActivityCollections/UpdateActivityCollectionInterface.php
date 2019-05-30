<?php

namespace Deviate\Activities\Contracts\Services\ActivityCollections;

interface UpdateActivityCollectionInterface
{
    public function updateById(string $collectionId, array $data): array;
}
