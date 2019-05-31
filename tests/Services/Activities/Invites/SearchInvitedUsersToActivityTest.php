<?php

namespace Deviate\Activities\Tests\Services\Invites;

use Deviate\Activities\Models\Eloquent\Invitation;
use Deviate\Activities\Tests\Services\TestCase;
use Deviate\Shared\Search\SearchContainer;

class SearchInvitedUsersToActivityTest extends TestCase
{
    /** @test */
    public function it_can_return_a_list_of_users_invited_to_an_activity()
    {
        Invitation::create([
            'activity_id' => 1,
            'user_id'     => 1,
        ]);

        $container = new SearchContainer;
        $container->perPage(5)->forPage(1);

        $response = $this->searchInvitationsClient->listInvitedUsers(1, $container);

        $response->assertSuccessful();

        $response->assertIsPaginated([
            'current_page'  => 1,
            'per_page'      => 5,
            'total_records' => 1,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(1);
    }
}
