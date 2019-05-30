<?php

namespace Deviate\Activities\Domain\BookingPreconditions;

use Carbon\Carbon;
use Deviate\Activities\Client\ActivitiesClientInterface;
use Deviate\Activities\Client\CollectionsClientInterface;
use Deviate\Activities\Exceptions\BookingNotOpenException;

class BookingMustBeOpen implements PreconditionInterface
{
    private $fetchesActivityCollections;
    private $fetchesActivities;

    public function __construct(
        CollectionsClientInterface $fetchesActivityCollections,
        ActivitiesClientInterface $fetchesActivities
    ) {
        $this->fetchesActivities = $fetchesActivities;
        $this->fetchesActivityCollections = $fetchesActivityCollections;
    }

    public function check(string $userId, string $activityId, bool $force = false): void
    {
        $activity = $this->fetchesActivities->fetchById($activityId);

        $collection = $this->fetchesActivityCollections->fetchCollection($activity->get('activity_collection_id'));

        $passes = Carbon::now()->between(
            Carbon::parse($collection->get('booking_starts_at')),
            Carbon::parse($collection->get('booking_ends_at'))
        );

        if (!$passes && !$force) {
            $this->throwException();
        }
    }

    public function throwException(): void
    {
        throw new BookingNotOpenException;
    }
}
