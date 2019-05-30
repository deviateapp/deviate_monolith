<?php

namespace Deviate\Usergroups\Tests\Services\Usergroups;

use Deviate\Usergroups\Models\Eloquent\Permission;
use Deviate\Usergroups\Models\Eloquent\Usergroup;
use Deviate\Usergroups\Tests\Services\TestCase;

class ListPermissionsInUsergroupTest extends TestCase
{
    /** @test */
    public function it_can_return_all_the_permissions_assigned_to_a_usergroup()
    {
        Usergroup::find(2)->permissions()->save(Permission::find(1));

        $response = $this->permissionsClient->listPermissionsInUsergroup($this->encode(2));

        $response->assertSuccessful();

        $this->assertEquals([
            [
                'key'               => 'test.permission',
                'name'              => 'Test permission',
                'description'       => 'This is a test permission',
                'must_own_resource' => false,
            ],
        ], $response->toArray());
    }

    /** @test */
    public function it_returns_an_error_if_the_usergroup_cant_be_found()
    {
        $response = $this->permissionsClient->listPermissionsInUsergroup($this->encode(999));

        $response->assertException([
            'status' => 404,
        ]);
    }
}
