<?php

namespace Deviate\Organisations\Tests\Services;

use Carbon\Carbon;

class UpdateOrganisationTest extends TestCase
{
    /** @test */
    public function an_organisation_can_be_updated()
    {
        $response = $this->client->updateOrganisation($this->encode(1), [
            'name' => 'Deviate Ltd',
            'slug' => 'Deviate Ltd Slug',
        ]);

        $response->assertContains([
            'name'       => 'Deviate Ltd',
            'slug'       => 'deviate-ltd-slug',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseHas('organisations', [
            'name' => 'Deviate Ltd',
            'slug' => 'deviate-ltd-slug',
        ]);
    }

    /** @test */
    public function the_slug_is_not_updated_if_not_supplied()
    {
        $response = $this->client->updateOrganisation($this->encode(1), [
            'name' => 'Deviate Ltd',
        ]);

        $response->assertContains([
            'name' => 'Deviate Ltd',
            'slug' => 'deviate',
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_the_organisation_doesnt_exist()
    {
        $response = $this->client->updateOrganisation($this->encode(999), [
            'name' => 'Deviate',
        ]);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_the_updated_slug_is_already_registered()
    {
        $response = $this->client->updateOrganisation($this->encode(1), [
            'slug' => 'citrium',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['slug'],
        ]);
    }
}
