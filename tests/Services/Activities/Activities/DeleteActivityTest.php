<?php

namespace Deviate\Activities\Tests\Services\Activities;

use Deviate\Activities\Tests\Services\TestCase;

class DeleteActivityTest extends TestCase
{
    /** @test */
    public function an_activity_can_be_deleted()
    {
        $response = $this->activitiesClient->delete(1);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('activities', [
            'id' => 1,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_activity_cant_be_found()
    {
        $response = $this->activitiesClient->delete(999);

        $response->assertException([
            'status' => 404,
        ]);
    }
}
