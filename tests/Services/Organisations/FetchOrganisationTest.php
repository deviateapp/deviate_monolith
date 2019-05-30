<?php

namespace Deviate\Organisations\Tests\Services;

use Carbon\Carbon;

class FetchOrganisationTest extends TestCase
{
    /** @test */
    public function it_can_return_an_organisation_by_its_id()
    {
        $response = $this->client->fetchOrganisationById(1);

        $response->assertContains([
            'id'         => 1,
            'name'       => 'Deviate',
            'slug'       => 'deviate',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_organisation_cannot_be_found()
    {
        $response = $this->client->fetchOrganisationById(999);

        $response->assertNotSuccessful();

        $response->assertException([
            'status' => 404,
        ]);
    }
}
