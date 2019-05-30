<?php

namespace Deviate\Activities\Contracts\Services\ActivityCollections;

interface DeleteActivityCollectionInterface
{
    public function deleteById(int $collectionId): void;
}
