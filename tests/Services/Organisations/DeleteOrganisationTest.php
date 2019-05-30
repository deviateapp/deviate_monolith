<?php

namespace Deviate\Organisations\Tests\Services;

class DeleteOrganisationTest extends TestCase
{
    /** @test */
    public function an_organisation_can_be_deleted()
    {
        $response = $this->client->deleteOrganisation(1);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('organisations', [
            'id' => 1,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_organisation_cant_be_found()
    {
        $response = $this->client->deleteOrganisation(999);

        $response->assertException([
            'status' => 404
        ]);
    }
}
