<?php

namespace Deviate\Activities\Repositories;

use Deviate\Activities\Contracts\Repositories\ActivityCollectionsRepositoryInterface;
use Deviate\Activities\Models\Eloquent\ActivityCollection;
use Deviate\Activities\Transformers\ActivityCollectionTransformer;
use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Shared\Search\SearchContainerInterface;

class ActivityCollectionsRepository extends AbstractRepository implements ActivityCollectionsRepositoryInterface
{
    private $activityCollection;
    private $transformer;

    public function __construct(ActivityCollection $activityCollection, ActivityCollectionTransformer $transformer)
    {
        $this->activityCollection = $activityCollection;
        $this->transformer        = $transformer;
    }

    public function fetchById(string $collectionId): array
    {
        $collection = $this->activityCollection->newQuery()->findOrFail($collectionId);

        return $this->transformer->transform($collection);
    }

    public function create(array $data): string
    {
        $collection = $this->activityCollection->newQuery()->create([
            'organisation_id'     => $data['organisation_id'],
            'name'                => $data['name'],
            'description'         => $data['description'],
            'booking_starts_at'   => $data['booking_starts_at'],
            'booking_ends_at'     => $data['booking_ends_at'],
            'payment_starts_at'   => $data['payment_starts_at'],
            'payment_ends_at'     => $data['payment_ends_at'],
            'activities_start_at' => $data['activities_start_at'],
            'activities_end_at'   => $data['activities_end_at'],
        ]);

        return $this->encode($collection->id);
    }

    public function fetchAll(): array
    {
        $collections = $this->activityCollection->newQuery()->orderBy('activities_start_at')->get();

        return $this->transformer->transformCollection($collections);
    }

    public function search(SearchContainerInterface $search): array
    {
        $paginator = $this->activityCollection->newQuery()->search($search);

        return $this->transformer->transformSearch($paginator);
    }

    public function deleteById(string $collectionId): bool
    {
        return $this->activityCollection->newQuery()->findOrFail($collectionId)->delete();
    }

    public function update(string $collectionId, array $data): bool
    {
        $collection = $this->activityCollection->newQuery()->findOrFail($collectionId)->toArray();
        $data       = array_merge($collection, $data);

        return $this->activityCollection->newQuery()->findOrFail($collectionId)->update([
            'name'                => $data['name'],
            'description'         => $data['description'],
            'booking_starts_at'   => $data['booking_starts_at'],
            'booking_ends_at'     => $data['booking_ends_at'],
            'payment_starts_at'   => $data['payment_starts_at'],
            'payment_ends_at'     => $data['payment_ends_at'],
            'activities_start_at' => $data['activities_start_at'],
            'activities_end_at'   => $data['activities_end_at'],
        ]);
    }
}
