<?php

namespace Deviate\Activities\Tests\Services\Activities;

use Deviate\Activities\Tests\Services\TestCase;
use Deviate\Activities\Models\Eloquent\ActivityCollection;

class CreateActivityTest extends TestCase
{
    /** @test */
    public function it_can_create_a_new_activity()
    {
        /** @var ActivityCollection $collection */
        $collection = ActivityCollection::find(1);

        $response = $this->activitiesClient->create($this->encode(1), [
            'name'                   => 'Test Activity',
            'description'            => 'This is a test activity, this is a test activity, this is a test activity',
            'starts_at'              => $collection->activities_start_at->format('Y-m-d'),
            'ends_at'                => $collection->activities_start_at->format('Y-m-d'),
            'places'                 => 10,
            'cost'                   => 1000,
            'is_hidden'              => true,
            'is_invite_only'         => true,
        ]);

        $response->assertSuccessful();

        $response->assertContains([
            'organisation_id'        => $this->encode(1),
            'activity_collection_id' => $this->encode(1),
            'name'                   => 'Test Activity',
            'description'            => 'This is a test activity, this is a test activity, this is a test activity',
            'starts_at'              => $collection->activities_start_at->format('Y-m-d'),
            'ends_at'                => $collection->activities_start_at->format('Y-m-d'),
            'places'                 => 10,
            'cost'                   => 1000,
            'is_hidden'              => true,
            'is_invite_only'         => true,
        ]);

        $this->assertDatabaseHas('activities', [
            'organisation_id'        => 1,
            'activity_collection_id' => 1,
            'name'                   => 'Test Activity',
            'description'            => 'This is a test activity, this is a test activity, this is a test activity',
            'starts_at'              => $collection->activities_start_at->format('Y-m-d 00:00:00'),
            'ends_at'                => $collection->activities_start_at->format('Y-m-d 23:59:59'),
            'places'                 => 10,
            'cost'                   => 1000,
            'is_hidden'              => true,
            'is_invite_only'         => true,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_collection_cannot_be_found()
    {
        $response = $this->activitiesClient->create($this->encode(999), []);

        $response->assertException([
            'status' => 422,
            'meta'   => ['activity_collection_id'],
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_data_provided_is_invalid()
    {
        $response = $this->activitiesClient->create($this->encode(1), []);

        $response->assertException([
            'status' => 422,
            'meta'   => ['name', 'description', 'starts_at', 'ends_at', 'places', 'cost'],
        ]);
    }

    /** @test */
    public function the_activity_start_date_must_be_greater_or_equal_to_the_start_date_for_the_collection()
    {
        /** @var ActivityCollection $collection */
        $collection = ActivityCollection::find(1);

        $response = $this->activitiesClient->create($this->encode(1), [
            'name'                   => 'Test Activity',
            'description'            => 'This is a test activity, this is a test activity, this is a test activity',
            'starts_at'              => $collection->activities_start_at->subDay()->format('Y-m-d'),
            'ends_at'                => $collection->activities_start_at->format('Y-m-d'),
            'places'                 => 10,
            'cost'                   => 1000,
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['starts_at'],
        ]);
    }

    /** @test */
    public function the_activity_end_date_must_be_less_than_or_equal_to_the_end_date_for_the_collection()
    {
        /** @var ActivityCollection $collection */
        $collection = ActivityCollection::find(1);

        $response = $this->activitiesClient->create($this->encode(1), [
            'name'                   => 'Test Activity',
            'description'            => 'This is a test activity, this is a test activity, this is a test activity',
            'starts_at'              => $collection->activities_start_at->format('Y-m-d'),
            'ends_at'                => $collection->activities_end_at->addDay()->format('Y-m-d'),
            'places'                 => 10,
            'cost'                   => 1000,
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['ends_at'],
        ]);
    }
}
