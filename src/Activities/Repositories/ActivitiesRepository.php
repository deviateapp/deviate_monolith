<?php

namespace Deviate\Activities\Repositories;

use Carbon\Carbon;
use Deviate\Activities\Contracts\Repositories\ActivitiesRepositoryInterface;
use Deviate\Activities\Contracts\Repositories\ActivityCollectionsRepositoryInterface;
use Deviate\Activities\Models\Eloquent\Activity;
use Deviate\Activities\Transformers\ActivityTransformer;
use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Shared\Search\SearchContainerInterface;

class ActivitiesRepository extends AbstractRepository implements ActivitiesRepositoryInterface
{
    private $activity;
    private $transformer;
    private $activityCollections;

    public function __construct(
        Activity $activity,
        ActivityTransformer $transformer,
        ActivityCollectionsRepositoryInterface $activityCollections
    ) {
        $this->activity            = $activity;
        $this->transformer         = $transformer;
        $this->activityCollections = $activityCollections;
    }

    public function search(SearchContainerInterface $search): array
    {
        $paginator = $this->activity->newQuery()->search($search);

        return $this->transformer->transformSearch($paginator);
    }

    public function fetchById(int $activityId): array
    {
        $activity = $this->activity->newQuery()->findOrFail($activityId);

        return $this->transformer->transform($activity);
    }

    public function create(array $data): int
    {
        $collection = $this->activityCollections->fetchById($data['activity_collection_id']);

        $activity = $this->activity->newQuery()->create([
            'organisation_id'        => $collection['organisation_id'],
            'activity_collection_id' => $data['activity_collection_id'],
            'name'                   => $data['name'],
            'description'            => $data['description'],
            'starts_at'              => Carbon::parse($data['starts_at'])->format('Y-m-d 00:00:00'),
            'ends_at'                => Carbon::parse($data['ends_at'])->format('Y-m-d 23:59:59'),
            'places'                 => $data['places'],
            'cost'                   => $data['cost'],
            'is_hidden'              => (bool) $data['is_hidden'],
            'is_invite_only'         => (bool) $data['is_invite_only'],
        ]);

        return $activity->id;
    }

    public function update(int $activityId, array $data): bool
    {
        $activity = $this->activity->newQuery()->findOrFail($activityId)->toArray();
        $data     = array_merge($activity, $data);

        $startsAt = Carbon::parse($data['starts_at']);
        $endsAt   = Carbon::parse($data['ends_at']);

        return $this->activity->newQuery()->findOrFail($activityId)->update([
            'name'           => $data['name'],
            'description'    => $data['description'],
            'starts_at'      => $startsAt->format('Y-m-d 00:00:00'),
            'ends_at'        => $endsAt->format('Y-m-d 23:59:59'),
            'places'         => $data['places'],
            'cost'           => $data['cost'],
            'is_hidden'      => (bool) $data['is_hidden'],
            'is_invite_only' => (bool) $data['is_invite_only'],
        ]);
    }

    public function delete(int $activityId): bool
    {
        return $this->activity->newQuery()->findOrFail($activityId)->delete();
    }
}
