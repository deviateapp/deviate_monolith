<?php

namespace Deviate\Activities\Tests\Services\Activities;

use Deviate\Activities\Models\Eloquent\Activity;
use Deviate\Activities\Tests\Services\TestCase;

class FetchActivityTest extends TestCase
{
    /** @test */
    public function an_activity_can_be_retrieved()
    {
        /** @var Activity $activity */
        $activity = Activity::find(1);

        $response = $this->activitiesClient->fetchById($this->encode(1));

        $response->assertSuccessful();

        $response->assertContains([
            'organisation_id'        => $this->encode(1),
            'activity_collection_id' => $this->encode(1),
            'name'                   => 'Paintballing',
            'description'            => 'This is a test paintballing activity',
            'starts_at'              => $activity->starts_at->format('Y-m-d'),
            'ends_at'                => $activity->ends_at->format('Y-m-d'),
            'places'                 => 30,
            'cost'                   => 2000,
        ]);
    }
}
