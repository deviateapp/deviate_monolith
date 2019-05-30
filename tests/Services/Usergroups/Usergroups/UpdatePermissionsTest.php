<?php

namespace Deviate\Usergroups\Tests\Services\Usergroups;

use Deviate\Usergroups\Tests\Services\TestCase;

class UpdatePermissionsTest extends TestCase
{
    /** @test */
    public function it_can_update_the_permissions_for_a_usergroup()
    {
        $response = $this->usergroupsClient->applyPermissions($this->encode(2), [
            [
                'key'               => 'test.permission',
                'must_own_resource' => true,
            ],
            [
                'key'               => 'test.permission.unownable',
                'must_own_resource' => false,
            ],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('permission_usergroup', [
            'usergroup_id'      => 2,
            'permission_id'     => 1,
            'must_own_resource' => true,
        ]);

        $this->assertDatabaseHas('permission_usergroup', [
            'usergroup_id'      => 2,
            'permission_id'     => 2,
            'must_own_resource' => false,
        ]);
    }

    /** @test */
    public function it_removes_permissions_that_dont_exist_from_being_updated()
    {
        $response = $this->usergroupsClient->applyPermissions($this->encode(2), [
            [
                'key' => 'invalid.permission',
            ],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('permission_usergroup', [
            'usergroup_id' => 2,
        ]);
    }

    /** @test */
    public function non_ownable_permissions_are_always_set_to_false()
    {
        $response = $this->usergroupsClient->applyPermissions($this->encode(2), [
            [
                'key'               => 'test.permission.unownable',
                'must_own_resource' => true,
            ],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('permission_usergroup', [
            'usergroup_id'      => 2,
            'permission_id'     => 2,
            'must_own_resource' => false,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_usergroup_cant_be_found()
    {
        $response = $this->usergroupsClient->applyPermissions($this->encode(999), []);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_data_isnt_formatted_correctly()
    {
        $response = $this->usergroupsClient->applyPermissions($this->encode(2), [
            [
                'foo_key'           => 'test.permission',
                'must_own_resource' => true,
            ],
            [
                'key'               => 'test.permission.unownable',
                'must_own_resource' => 'blah',
            ],
        ]);

        $response->assertException([
            'status' => 422,
            'meta'   => ['permissions.0.key', 'permissions.1.must_own_resource'],
        ]);
    }
}
