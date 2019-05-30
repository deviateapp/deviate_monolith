<?php

namespace Deviate\Activities\Contracts\Services\ActivityCollections;

interface UpdateActivityCollectionInterface
{
    public function updateById(int $collectionId, array $data): array;
}
