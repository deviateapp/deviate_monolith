<?php

namespace Deviate\Activities\Tests\Services\Bookings;

use Deviate\Activities\Models\Eloquent\ActivityCollection;
use Deviate\Activities\Tests\Services\TestCase;

class CheckCanBookTest extends TestCase
{
    /** @test */
    public function it_can_return_whether_a_user_can_book_a_given_activity()
    {
        ActivityCollection::find(1)->update([
            'booking_starts_at' => now()->subDay(),
        ]);

        $response = $this->bookingsClient->canBook(1, 1);

        $response->assertSuccessful();

        $response->assertContains([
            'can_book' => true,
        ]);
    }

    /** @test */
    public function it_returns_false_with_a_list_of_reasons_why_a_user_cannot_book_a_given_activity()
    {
        $response = $this->bookingsClient->canBook(1, 1);

        $response->assertSuccessful();

        $this->assertEquals([
            'can_book' => false,
            'reasons' => [
                'Booking is not open for this activity.',
            ],
        ], $response->toArray());
    }

    /** @test */
    public function it_can_return_whether_a_user_can_unbook_a_given_activity()
    {
        ActivityCollection::find(1)->update([
            'booking_starts_at' => now()->subDay(),
        ]);

        $response = $this->bookingsClient->canUnbook(1, 1);

        $response->assertSuccessful();

        $response->assertContains([
            'can_unbook' => true,
        ]);
    }

    /** @test */
    public function it_returns_false_with_a_list_of_reasons_why_a_user_cannot_unbook_a_given_activity()
    {
        $response = $this->bookingsClient->canUnbook(1, 1);

        $response->assertSuccessful();

        $this->assertEquals([
            'can_unbook' => false,
            'reasons' => [
                'Booking is not open for this activity.',
            ],
        ], $response->toArray());
    }
}
