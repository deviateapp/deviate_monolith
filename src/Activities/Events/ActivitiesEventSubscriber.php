<?php

namespace Deviate\Activities\Events;

use Deviate\Activities\Contracts\Events\ActivitiesEventSubscriberInterface;
use Deviate\Activities\Contracts\Services\Activities\CreateActivityInterface;
use Deviate\Activities\Contracts\Services\Activities\DeleteActivityInterface;
use Deviate\Activities\Contracts\Services\Activities\FetchActivityInterface;
use Deviate\Activities\Contracts\Services\Activities\UpdateActivityInterface;
use Deviate\Shared\Events\AbstractEventSubscriber;

class ActivitiesEventSubscriber extends AbstractEventSubscriber implements ActivitiesEventSubscriberInterface
{
    protected $events = [
        'activities.fetch_by_id'  => 'handleFetchActivity',
        'activities.create'       => 'handleCreateActivity',
        'activities.update.by_id' => 'handleUpdateActivity',
        'activities.delete.by_id' => 'handleDeleteActivity',
        'activities.search'       => 'handleSearchActivities',
    ];

    private $fetchActivity;
    private $createActivity;
    private $updateActivity;
    private $deleteActivity;

    public function __construct(
        FetchActivityInterface $fetchActivities,
        CreateActivityInterface $createActivity,
        UpdateActivityInterface $updateActivity,
        DeleteActivityInterface $deleteActivity
    ) {
        $this->fetchActivity  = $fetchActivities;
        $this->createActivity = $createActivity;
        $this->updateActivity = $updateActivity;
        $this->deleteActivity = $deleteActivity;
    }

    public function handleSearchActivities(array $payload): array
    {
        return $this->fetchActivity->search(unserialize($payload['parameters']));
    }

    public function handleFetchActivity(array $payload): array
    {
        return $this->fetchActivity->fetchById($payload['id']);
    }

    public function handleCreateActivity(array $payload): array
    {
        return $this->createActivity->createSingleActivity($payload);
    }

    public function handleUpdateActivity(array $payload): array
    {
        return $this->updateActivity->updateById($payload['id'], $payload);
    }

    public function handleDeleteActivity(array $payload): void
    {
        $this->deleteActivity->deleteById($payload['id']);
    }
}
