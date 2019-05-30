<?php

namespace Deviate\Activities\Tests\Services\Bookings;

use Deviate\Activities\Tests\Services\TestCase;
use Deviate\Shared\Search\SearchContainer;
use Illuminate\Support\Facades\DB;

class ListBookedUsersTest extends TestCase
{
    /** @test */
    public function it_can_return_a_list_of_users_booked_on_an_activity()
    {
        DB::table('activity_user')->insert([
            [
                'activity_id' => 1,
                'user_id'     => 1,
                'status'      => 'booked',
                'created_at'  => now()->format('Y-m-d H:i:s'),
                'updated_at'  => now()->format('Y-m-d H:i:s'),
            ],
            [
                'activity_id' => 1,
                'user_id'     => 2,
                'status'      => 'invited',
                'created_at'  => now()->format('Y-m-d H:i:s'),
                'updated_at'  => now()->format('Y-m-d H:i:s'),
            ],
        ]);
        $container = new SearchContainer();
        $container->perPage(5)->forPage(1);

        $response = $this->searchBookingsClient->listBookedUsers(1, $container);

        $response->assertSuccessful();

        $response->assertIsPaginated([
            'current_page'  => 1,
            'per_page'      => 5,
            'total_records' => 1,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(1);
    }

    /** @test */
    public function it_returns_an_error_if_the_activity_cannot_be_found_when_listing_bookings()
    {
        $container = new SearchContainer;

        $response = $this->searchBookingsClient->listBookedUsers(999, $container);

        $response->assertException([
            'status' => 404,
        ]);
    }
}
