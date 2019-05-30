<?php

namespace Deviate\Activities\Tests\Services\Bookings;

use Deviate\Activities\Models\Eloquent\Activity;
use Deviate\Activities\Models\Eloquent\ActivityCollection;
use Deviate\Activities\Tests\Services\TestCase;
use Illuminate\Support\Facades\DB;

class BookActivityTest extends TestCase
{
    /** @test */
    public function a_user_can_be_booked_on_an_activity()
    {
        ActivityCollection::find(1)->update([
            'booking_starts_at' => now()->subDay(),
        ]);

        $response = $this->bookingsClient->book(1, 1);

        $response->assertSuccessful();

        $this->assertDatabaseHas('activity_user', [
            'activity_id' => 1,
            'user_id'     => 1,
            'status'      => 'booked',
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_the_user_cant_be_found_when_booking()
    {
        $response = $this->bookingsClient->book(999, 1);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_the_activity_cant_be_found_when_booking()
    {
        $response = $this->bookingsClient->book(1, 999);

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_booking_is_not_open_when_trying_to_book_an_activity()
    {
        ActivityCollection::find(1)->update([
            'booking_starts_at' => now()->addDays(2)->format('Y-m-d 00:00:00'),
        ]);

        $response = $this->bookingsClient->book(1, 1);

        $response->assertException([
            'status' => 409,
        ]);
    }

    /** @test */
    public function a_user_can_be_force_booked_onto_an_activity_anytime_before_the_activity_starts()
    {
        $response = $this->bookingsClient->book(1, 1, true);

        $response->assertSuccessful();

        $this->assertDatabaseHas('activity_user', [
            'activity_id' => 1,
            'user_id'     => 1,
            'status'      => 'booked',
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_is_already_booked()
    {
        DB::table('activity_user')->insert([
            'user_id'     => 1,
            'activity_id' => 1,
            'status'      => 'booked',
        ]);

        $response = $this->bookingsClient->book(1, 1, true);

        $response->assertException([
            'status' => 400,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_user_is_already_booked_on_an_activity_that_overlaps_the_requested_activity(
    )
    {
        DB::table('activity_user')->insert([
            'user_id'     => 1,
            'activity_id' => 1,
            'status'      => 'booked',
        ]);

        $response = $this->bookingsClient->book(1, 2, true);

        $response->assertException([
            'status' => 409,
        ]);
    }

    /** @test */
    public function an_error_is_returned_when_trying_to_book_an_invite_only_activity()
    {
        Activity::find(1)->update([
            'is_invite_only' => true,
        ]);

        ActivityCollection::find(1)->update([
            'booking_starts_at' => now()->subDay(),
        ]);

        $response = $this->bookingsClient->book(1, 1);

        $response->assertException([
            'status' => 409,
        ]);
    }

    /** @test */
    public function if_a_user_has_been_invited_to_an_activity_they_can_accept_the_booking_normally()
    {
        DB::table('activity_user')->insert([
            'user_id'     => 1,
            'activity_id' => 1,
            'status'      => 'invited',
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s'),
        ]);

        Activity::find(1)->update([
            'is_invite_only' => true,
        ]);

        ActivityCollection::find(1)->update([
            'booking_starts_at' => now()->subDay(),
        ]);

        $response = $this->bookingsClient->book(1, 1);

        $response->assertSuccessful();

        $this->assertDatabaseHas('activity_user', [
            'user_id'     => 1,
            'activity_id' => 1,
            'status'      => 'booked',
        ]);
    }
}
