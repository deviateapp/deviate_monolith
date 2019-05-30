<?php

namespace Deviate\Usergroups\Tests\Services\Usergroups;

use Deviate\Usergroups\Models\Eloquent\Permission;
use Deviate\Usergroups\Models\Eloquent\Usergroup;
use Deviate\Usergroups\Tests\Services\TestCase;

class FetchUsergroupTest extends TestCase
{
    /** @test */
    public function it_can_return_a_usergroup()
    {
        Usergroup::find(1)->permissions()->save(Permission::find(1));

        $response = $this->usergroupsClient->fetchUsergroup($this->encode(1));

        $response->assertSuccessful();

        $response->assertContains([
            'id'              => $this->encode(1),
            'organisation_id' => $this->encode(1),
            'name'            => 'Network Administrators',
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_usergroup_cant_be_found()
    {
        $response = $this->usergroupsClient->fetchUsergroup($this->encode(999));

        $response->assertException([
            'status' => 404,
        ]);
    }
}
