<?php

namespace Deviate\Activities\Contracts\Services\ActivityCollections;

interface CreateActivityCollectionInterface
{
    public function createSingleCollection(array $data): array;
}
