<?php

namespace Deviate\Usergroups\Tests\Services\Usergroups;

use Deviate\Usergroups\Tests\Services\TestCase;

class DeleteUsergroupTest extends TestCase
{
    /** @test */
    public function a_usergroup_can_be_deleted()
    {
        $response = $this->usergroupsClient->deleteUsergroup(1);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('usergroups', [
            'id' => 1,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_usergroup_cannot_be_found()
    {
        $response = $this->usergroupsClient->deleteUsergroup(999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_removes_all_users_from_the_group_when_deleting()
    {
        $response = $this->usergroupsClient->deleteUsergroup(1);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('user_usergroup', [
            'usergroup_id' => 1,
        ]);

        $this->assertDatabaseHas('user_usergroup', [
            'usergroup_id' => 2,
        ]);
    }
}
