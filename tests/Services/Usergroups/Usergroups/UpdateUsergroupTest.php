<?php

namespace Deviate\Usergroups\Tests\Services\Usergroups;

use Carbon\Carbon;
use Deviate\Usergroups\Models\Eloquent\Usergroup;
use Deviate\Usergroups\Tests\Services\TestCase;

class UpdateUsergroupTest extends TestCase
{
    /** @test */
    public function a_usergroup_can_be_updated()
    {
        $response = $this->usergroupsClient->updateUsergroup($this->encode(2), [
            'name'          => 'Administrators',
            'description'   => 'Administrators usergroup',
            'is_supergroup' => true,
        ]);

        $response->assertSuccessful();

        $response->assertContains([
            'id'            => $this->encode(2),
            'name'          => 'Administrators',
            'description'   => 'Administrators usergroup',
            'is_supergroup' => true,
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseHas('usergroups', [
            'id'            => 2,
            'name'          => 'Administrators',
            'description'   => 'Administrators usergroup',
            'is_supergroup' => true,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_usergroup_cant_be_found()
    {
        $response = $this->usergroupsClient->updateUsergroup($this->encode(999), []);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_validation_fails()
    {
        $response = $this->usergroupsClient->updateUsergroup($this->encode(1), [
            'name' => 'A',
            'description' => 'B',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['name', 'description'],
        ]);
    }

    /** @test */
    public function it_only_updates_supplied_fields()
    {
        $originalDescription = Usergroup::find(1)->description;

        $response = $this->usergroupsClient->updateUsergroup($this->encode(1), [
            'name'          => 'Administrators usergroup',
            'is_supergroup' => false,
        ]);

        $response->assertSuccessful();

        $response->assertContains([
            'name'          => 'Administrators usergroup',
            'description'   => $originalDescription,
            'is_supergroup' => false,
        ]);

        $this->assertDatabaseHas('usergroups', [
            'id'            => 1,
            'name'          => 'Administrators usergroup',
            'description'   => $originalDescription,
            'is_supergroup' => false,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_new_name_is_already_taken_in_the_organisation()
    {
        $response = $this->usergroupsClient->updateUsergroup($this->encode(2), [
            'name' => 'Standard Usergroup',
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['name'],
        ]);
    }
}
