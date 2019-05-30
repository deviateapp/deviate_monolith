<?php

namespace Deviate\Usergroups\Tests\Services\Usergroups;

use Carbon\Carbon;
use Deviate\Usergroups\Tests\Services\TestCase;

class CreateUsergroupTest extends TestCase
{
    /** @test */
    public function it_can_create_a_new_usergroup()
    {
        $response = $this->usergroupsClient->createUsergroup([
            'organisation_id' => 1,
            'name'            => 'Test Usergroup',
            'description'     => 'This is a test usergroup',
            'is_supergroup'   => true,
        ]);

        $response->assertContains([
            'name'          => 'Test Usergroup',
            'description'   => 'This is a test usergroup',
            'is_supergroup' => true,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseHas('usergroups', [
            'organisation_id' => 1,
            'name'            => 'Test Usergroup',
            'description'     => 'This is a test usergroup',
            'is_supergroup'   => true,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_invalid_data_is_used()
    {
        $response = $this->usergroupsClient->createUsergroup([]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['organisation_id', 'name', 'description'],
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_organisation_doesnt_exist()
    {
        $response = $this->usergroupsClient->createUsergroup([
            'organisation_id' => 999,
            'name'            => 'Test Usergroup',
            'description'     => 'This is a test usergroup',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['organisation_id'],
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_usergroup_name_already_exists_for_the_organisation()
    {
        $response = $this->usergroupsClient->createUsergroup([
            'organisation_id' => 1,
            'name'            => 'Network Administrators',
            'description'     => 'Test usergroup',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['name'],
        ]);
    }
}
