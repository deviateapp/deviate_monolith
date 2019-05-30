<?php

namespace Deviate\Activities\Tests\Services\ActivityCollections;

use Deviate\Activities\Models\Eloquent\ActivityCollection;
use Deviate\Activities\Tests\Services\TestCase;

class FetchActivityCollectionTest extends TestCase
{
    /** @test */
    public function an_activity_collection_can_be_retrieved()
    {
        /** @var ActivityCollection $collection */
        $collection = ActivityCollection::find(1);

        $response = $this->collectionsClient->fetchCollection(1);

        $response->assertSuccessful();

        $response->assertContains([
            'organisation_id'     => 1,
            'name'                => $collection->name,
            'description'         => $collection->description,
            'booking_starts_at'   => $collection->booking_starts_at->format('Y-m-d 00:00:00'),
            'booking_ends_at'     => $collection->booking_ends_at->format('Y-m-d 23:59:59'),
            'payment_starts_at'   => $collection->payment_starts_at->format('Y-m-d 00:00:00'),
            'payment_ends_at'     => $collection->payment_ends_at->format('Y-m-d 23:59:59'),
            'activities_start_at' => $collection->activities_start_at->format('Y-m-d 00:00:00'),
            'activities_end_at'   => $collection->activities_end_at->format('Y-m-d 23:59:59'),
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_usergroup_cannot_be_found()
    {
        $response = $this->collectionsClient->fetchCollection(999);

        $response->assertException([
            'status' => 404,
        ]);
    }
}
