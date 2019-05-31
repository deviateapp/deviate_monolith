<?php

namespace Deviate\Activities\Tests\Services\Invites;

use Deviate\Activities\Models\Eloquent\Invitation;
use Deviate\Activities\Tests\Services\TestCase;
use Deviate\Shared\Search\SearchContainer;

class SearchActivitiesUserInvitedToTest extends TestCase
{
    /** @test */
    public function it_can_return_a_list_of_activities_a_user_has_been_invited_to()
    {
        Invitation::create([
            'activity_id' => 1,
            'user_id'     => 1,
        ]);

        $container = new SearchContainer;
        $container->perPage(5)->forPage(1);

        $response = $this->searchInvitationsClient->listInvitedActivities(1, $container);

        $response->assertSuccessful();

        $response->assertIsPaginated([
            'current_page'  => 1,
            'per_page'      => 5,
            'total_records' => 1,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(1);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_cant_be_found()
    {
        $response = $this->searchInvitationsClient->listInvitedActivities(999, new SearchContainer);

        $response->assertException([
            'status' => 404,
        ]);
    }
}
