<?php

namespace Deviate\Usergroups\Tests\Services\Membership;

use Deviate\Shared\Search\SearchContainer;
use Deviate\Usergroups\Tests\Services\TestCase;

class MembershipTest extends TestCase
{
    /** @test */
    public function it_an_add_a_user_to_a_usergroup()
    {
        $response = $this->membershipClient->join(3, 1);

        $response->assertSuccessful();

        $this->assertDatabaseHas('user_usergroup', [
            'user_id'      => 3,
            'usergroup_id' => 1,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cannot_be_found_when_joining_a_usergroup()
    {
        $response = $this->membershipClient->join(999, 1);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_usergroup_cannot_be_found_when_joining_a_usergroup()
    {
        $response = $this->membershipClient->join(3, 999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_can_remove_a_user_from_a_usergroup()
    {
        $response = $this->membershipClient->remove(2, 1);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('user_usergroup', [
            'user_id'      => 2,
            'usergroup_id' => 1,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cannot_be_found_when_removing_a_user_from_a_usergroup()
    {
        $response = $this->membershipClient->remove(999, 1);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_usergroup_cannot_be_found_when_removing_a_user_from_a_usergroup()
    {
        $response = $this->membershipClient->remove(3, 999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_can_remove_a_user_from_all_usergroups()
    {
        $response = $this->membershipClient->removeByUserId(2);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('user_usergroup', [
            'user_id' => 2,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found_when_removing_a_user_from_all_usergroups()
    {
        $response = $this->membershipClient->removeByUserId(999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_can_remove_all_users_of_a_usergroup()
    {
        $response = $this->membershipClient->removeByUsergroupId(1);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('user_usergroup', [
            'usergroup_id' => 1,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found_when_removing_all_users_from_a_usergroup()
    {
        $response = $this->membershipClient->removeByUserId(999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function it_can_list_members_in_a_usergroup()
    {
        $container = new SearchContainer;
        $container->perPage(5)->forPage(1);

        $response = $this->membershipClient->listMembers(1, $container);

        $response->assertSuccessful();

        $response->assertIsPaginated([
            'current_page'  => 1,
            'per_page'      => 5,
            'total_records' => 1,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(2);
    }

    /** @test */
    public function it_returns_an_error_when_trying_to_find_users_of_a_non_existing_usergroup()
    {
        $container = new SearchContainer;

        $response = $this->membershipClient->listMembers(999, $container);

        $response->assertException([
            'status' => 404,
        ]);
    }
}
