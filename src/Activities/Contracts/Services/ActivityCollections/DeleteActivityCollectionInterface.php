<?php

namespace Deviate\Activities\Contracts\Services\ActivityCollections;

interface DeleteActivityCollectionInterface
{
    public function deleteById(string $collectionId): void;
}
