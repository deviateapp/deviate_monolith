<?php

namespace Deviate\Activities\Tests\Services\Activities;

use Deviate\Activities\Models\Eloquent\Activity;
use Deviate\Activities\Tests\Services\TestCase;

class UpdateActivityTest extends TestCase
{
    /** @test */
    public function an_activity_can_be_updated()
    {
        /** @var Activity $activity */
        $activity = Activity::find(1);

        $response = $this->activitiesClient->updateDetails($this->encode(1), [
            'name'           => 'Test Activity',
            'description'    => 'This is a test activity, this is a test activity, this is a test activity',
            'starts_at'      => $activity->starts_at->addDay()->format('Y-m-d'),
            'ends_at'        => $activity->starts_at->addDays(2)->format('Y-m-d'),
            'places'         => 2,
            'cost'           => 10000,
            'is_hidden'      => true,
            'is_invite_only' => true,
        ]);

        $response->assertSuccessful();

        $response->assertContains([
            'name'           => 'Test Activity',
            'description'    => 'This is a test activity, this is a test activity, this is a test activity',
            'starts_at'      => $activity->starts_at->addDay()->format('Y-m-d'),
            'ends_at'        => $activity->starts_at->addDays(2)->format('Y-m-d'),
            'places'         => 2,
            'cost'           => 10000,
            'is_hidden'      => true,
            'is_invite_only' => true,
        ]);

        $this->assertDatabaseHas('activities', [
            'id'             => 1,
            'name'           => 'Test Activity',
            'description'    => 'This is a test activity, this is a test activity, this is a test activity',
            'starts_at'      => $activity->starts_at->addDay()->format('Y-m-d 00:00:00'),
            'ends_at'        => $activity->starts_at->addDays(2)->format('Y-m-d 23:59:59'),
            'places'         => 2,
            'cost'           => 10000,
            'is_hidden'      => true,
            'is_invite_only' => true,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_activity_cant_be_found()
    {
        $response = $this->activitiesClient->updateDetails($this->encode(999), []);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_only_updates_specified_fields()
    {
        /** @var Activity $activity */
        $activity = Activity::find(1);

        $response = $this->activitiesClient->updateDetails($this->encode(1), [
            'name'        => 'Test Activity',
            'description' => 'This is a test activity, this is a test activity, this is a test activity',
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'id'             => 1,
            'name'           => 'Test Activity',
            'description'    => 'This is a test activity, this is a test activity, this is a test activity',
            'starts_at'      => $activity->starts_at->format('Y-m-d H:i:s'),
            'ends_at'        => $activity->ends_at->format('Y-m-d H:i:s'),
            'places'         => $activity->places,
            'cost'           => $activity->cost,
            'is_hidden'      => false,
            'is_invite_only' => false,
        ]);
    }

    /** @test */
    public function it_returns_a_validation_error_if_the_data_is_invalid()
    {
        $response = $this->activitiesClient->updateDetails($this->encode(1), [
            'name'           => 'A',
            'description'    => 'B',
            'starts_at'      => '2019-01-',
            'ends_at'        => '2019-01-',
            'places'         => -1,
            'cost'           => -1,
            'is_hidden'      => 'foo',
            'is_invite_only' => 'bar',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['name', 'description', 'starts_at', 'ends_at', 'places', 'cost', 'is_hidden', 'is_invite_only'],
        ]);
    }
}
