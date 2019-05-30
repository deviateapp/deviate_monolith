<?php

namespace Deviate\Activities\Tests\Services\ActivityCollections;

use Deviate\Activities\Models\Eloquent\ActivityCollection;
use Deviate\Activities\Tests\Services\TestCase;

class UpdateActivityCollectionTest extends TestCase
{
    /** @test */
    public function it_can_update_a_collections_details()
    {
        $response = $this->collectionsClient->updateCollection(2, [
            'name'                => 'Updated collection',
            'description'         => 'This is an updated collection',
            'booking_starts_at'   => '2021-01-01 00:00:00',
            'booking_ends_at'     => '2021-01-09 23:59:59',
            'payment_starts_at'   => '2021-01-10 00:00:00',
            'payment_ends_at'     => '2021-01-19 23:59:59',
            'activities_start_at' => '2021-01-20 00:00:00',
            'activities_end_at'   => '2021-01-29 23:59:59',
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('activity_collections', [
            'id'                  => 2,
            'name'                => 'Updated collection',
            'description'         => 'This is an updated collection',
            'booking_starts_at'   => '2021-01-01 00:00:00',
            'booking_ends_at'     => '2021-01-09 23:59:59',
            'payment_starts_at'   => '2021-01-10 00:00:00',
            'payment_ends_at'     => '2021-01-19 23:59:59',
            'activities_start_at' => '2021-01-20 00:00:00',
            'activities_end_at'   => '2021-01-29 23:59:59',
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_collection_cannot_be_found()
    {
        $response = $this->collectionsClient->updateCollection(999, []);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_a_validation_error_if_the_data_is_invalid()
    {
        $response = $this->collectionsClient->updateCollection(1, [
            'name'        => 'A',
            'description' => 'B',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['name', 'description'],
        ]);
    }

    /** @test */
    public function when_updating_dates_all_dates_must_be_provided()
    {
        $response = $this->collectionsClient->updateCollection(1, [
            'booking_starts_at' => '2018-12-31 23:59:59',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => [
                'booking_ends_at',
                'payment_starts_at',
                'payment_ends_at',
                'activities_start_at',
                'activities_end_at',
            ],
        ]);
    }

    /** @test */
    public function it_only_updates_supplied_data()
    {
        /** @var ActivityCollection $collection */
        $collection = ActivityCollection::find(1);

        $response = $this->collectionsClient->updateCollection(1, [
            'name' => 'Test Activity',
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('activity_collections', [
            'id'          => 1,
            'name'        => 'Test Activity',
            'description' => $collection->description,
        ]);
    }
}
