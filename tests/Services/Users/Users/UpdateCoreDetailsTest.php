<?php

namespace Deviate\Users\Tests\Services\Users;

use Deviate\Users\Tests\Services\TestCase;

class UpdateCoreDetailsTest extends TestCase
{
    /** @test */
    public function it_can_update_a_users_core_details()
    {
        $response = $this->updatesUsersClient->updateCoreDetails(1, [
            'forename' => 'Brody Jax',
            'surname'  => 'Andrew Cross',
            'email'    => 'brody.cross@deviate.test',
        ]);

        $response->assertSuccessful();

        $response->assertContains([
            'forename' => 'Brody Jax',
            'surname'  => 'Andrew Cross',
            'email'    => 'brody.cross@deviate.test',
        ]);

        $this->assertDatabaseHas('users', [
            'id'       => 1,
            'forename' => 'Brody Jax',
            'surname'  => 'Andrew Cross',
            'email'    => 'brody.cross@deviate.test',
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found()
    {
        $response = $this->updatesUsersClient->updateCoreDetails(999, []);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_only_updates_supplied_fields()
    {
        $response = $this->updatesUsersClient->updateCoreDetails(1, [
            'forename' => 'Brody Jax Andrew',
        ]);

        $response->assertContains([
            'forename' => 'Brody Jax Andrew',
            'surname'  => 'Cross',
            'email'    => 'brody@deviate.test',
        ]);

        $this->assertDatabaseHas('users', [
            'id'       => 1,
            'forename' => 'Brody Jax Andrew',
            'surname'  => 'Cross',
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_supplied_data_is_invalid()
    {
        $response = $this->updatesUsersClient->updateCoreDetails(1, [
            'forename' => 'a',
            'surname'  => 'b',
            'email'    => 'c',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['forename', 'surname', 'email'],
        ]);
    }
}
