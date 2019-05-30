<?php

namespace Deviate\Activities\Events;

use Deviate\Activities\Contracts\Events\CollectionsEventSubscriberInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\CreateActivityCollectionInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\DeleteActivityCollectionInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\FetchActivityCollectionInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\UpdateActivityCollectionInterface;
use Deviate\Shared\Events\AbstractEventSubscriber;

class CollectionsEventSubscriber extends AbstractEventSubscriber implements CollectionsEventSubscriberInterface
{
    protected $events = [
        'activities.collections.fetch_by_id'  => 'handleFetchCollection',
        'activities.collections.create'       => 'handleCreateCollection',
        'activities.collections.search'       => 'handleSearch',
        'activities.collections.delete_by_id' => 'handleDeleteCollection',
        'activities.collections.update'       => 'handleUpdateCollection',
    ];

    private $fetchCollections;
    private $createCollections;
    private $updateCollections;
    private $deleteCollections;

    public function __construct(
        FetchActivityCollectionInterface $fetchCollections,
        CreateActivityCollectionInterface $createCollections,
        UpdateActivityCollectionInterface $updateCollections,
        DeleteActivityCollectionInterface $deleteCollections
    ) {
        $this->fetchCollections  = $fetchCollections;
        $this->createCollections = $createCollections;
        $this->updateCollections = $updateCollections;
        $this->deleteCollections = $deleteCollections;
    }

    public function handleFetchCollection(array $payload): array
    {
        return $this->fetchCollections->fetchById($payload['id']);
    }

    public function handleCreateCollection(array $payload): array
    {
        return $this->createCollections->createSingleCollection($payload);
    }

    public function handleSearch(array $payload): array
    {
        return $this->fetchCollections->search(unserialize($payload['parameters']));
    }

    public function handleDeleteCollection(array $payload): void
    {
        $this->deleteCollections->deleteById($payload['id']);
    }

    public function handleUpdateCollection(array $payload): array
    {
        return $this->updateCollections->updateById($payload['id'], $payload);
    }
}
