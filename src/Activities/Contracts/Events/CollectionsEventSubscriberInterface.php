<?php

namespace Deviate\Activities\Contracts\Events;

use Deviate\Shared\Events\EventSubscriberInterface;

interface CollectionsEventSubscriberInterface extends EventSubscriberInterface
{
    public function handleFetchCollection(array $payload): array;
    public function handleCreateCollection(array $payload): array;
    public function handleSearch(array $payload): array;
    public function handleDeleteCollection(array $payload): void;
    public function handleUpdateCollection(array $payload): array;
}
