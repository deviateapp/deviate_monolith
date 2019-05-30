<?php

namespace Deviate\Organisations\Tests\Services;

use Carbon\Carbon;

class CreateOrganisationTest extends TestCase
{
    /** @test */
    public function test_an_organisation_can_be_created()
    {
        $response = $this->client->createOrganisation([
            'name' => 'Westlands',
        ]);

        $response->assertContains([
            'name'       => 'Westlands',
            'slug'       => 'westlands',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseHas('organisations', [
            'name' => 'Westlands',
            'slug' => 'westlands',
        ]);
    }

    /** @test */
    public function test_a_slug_can_be_defined()
    {
        $response = $this->client->createOrganisation([
            'name' => 'Westlands',
            'slug' => 'Westlands School Torquay',
        ]);

        $response->assertContains([
            'name' => 'Westlands',
            'slug' => 'westlands-school-torquay',
        ]);

        $this->assertDatabaseHas('organisations', [
            'name' => 'Westlands',
            'slug' => 'westlands-school-torquay',
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_the_slug_has_already_been_registered()
    {
        $response = $this->client->createOrganisation([
            'name' => 'Deviate',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['slug'],
        ]);
    }

    /** @test */
    public function a_validation_error_is_returned_if_the_data_is_invalid()
    {
        $response = $this->client->createOrganisation([
            'name' => 'a',
            'slug' => 'b',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['name', 'slug'],
        ]);
    }
}
