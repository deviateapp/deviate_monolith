<?php

namespace Deviate\Activities\Tests\Services\ActivityCollections;

use Deviate\Activities\Tests\Services\TestCase;

class CreateActivityCollectionTest extends TestCase
{
    /** @test */
    public function it_can_create_a_new_activity_collection()
    {
        $data = [
            'organisation_id'     => 1,
            'name'                => 'Test Collection',
            'description'         => 'This is a test collection',
            'booking_starts_at'   => '2019-01-01 00:00:00',
            'booking_ends_at'     => '2019-01-09 23:59:59',
            'payment_starts_at'   => '2019-01-10 00:00:00',
            'payment_ends_at'     => '2019-01-19 23:59:59',
            'activities_start_at' => '2019-01-20 00:00:00',
            'activities_end_at'   => '2019-01-29 00:00:00',
        ];

        $response = $this->collectionsClient->createCollection($data);

        $response->assertSuccessful();

        $response->assertContains($data);

        $this->assertDatabaseHas('activity_collections', array_merge($data, [
            'organisation_id' => 1,
        ]));
    }

    /** @test */
    public function it_returns_an_error_if_validation_fails()
    {
        $response = $this->collectionsClient->createCollection([]);

        $response->assertException([
            'status' => 422,
            'meta'   => [
                'organisation_id',
                'name',
                'description',
                'booking_starts_at',
                'booking_ends_at',
                'payment_starts_at',
                'payment_ends_at',
                'activities_start_at',
                'activities_end_at',
            ],
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_organisation_doesnt_exist()
    {
        $response = $this->collectionsClient->createCollection([
            'organisation_id'     => 999,
            'name'                => 'Test Collection',
            'description'         => 'This is a test collection',
            'booking_starts_at'   => '2019-01-01 00:00:00',
            'booking_ends_at'     => '2019-01-09 23:59:59',
            'payment_starts_at'   => '2019-01-10 00:00:00',
            'payment_ends_at'     => '2019-01-19 23:59:59',
            'activities_start_at' => '2019-01-20 00:00:00',
            'activities_end_at'   => '2019-01-29 00:00:00',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['organisation_id'],
        ]);
    }
}
