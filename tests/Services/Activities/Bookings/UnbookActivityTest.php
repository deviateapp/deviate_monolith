<?php

namespace Deviate\Activities\Tests\Services\Bookings;

use Deviate\Activities\Models\Eloquent\ActivityCollection;
use Deviate\Activities\Tests\Services\TestCase;
use Illuminate\Support\Facades\DB;

class UnbookActivityTest extends TestCase
{
    /** @test */
    public function a_user_can_be_unbooked_from_an_activity()
    {
        ActivityCollection::find(1)->update([
            'booking_starts_at' => now()->subDay(),
        ]);

        DB::table('activity_user')->insert([
            'user_id'     => 1,
            'activity_id' => 1,
            'status'      => 'booked',
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s'),
        ]);

        $response = $this->bookingsClient->unbook($this->encode(1), $this->encode(1));

        $response->assertSuccessful();

        $this->assertDatabaseMissing('activity_user', [
            'user_id'     => 1,
            'activity_id' => 1,
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_the_user_cannot_be_found_when_unbooking()
    {
        $response = $this->bookingsClient->unbook($this->encode(999), $this->encode(1));

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_the_activity_cannot_be_found_when_unbooking()
    {
        $response = $this->bookingsClient->unbook($this->encode(1), $this->encode(999));

        $response->assertException([
            'status' => 404,
        ]);
    }

    /** @test */
    public function an_error_is_returned_if_booking_is_not_open_when_trying_to_unbook_a_user()
    {
        DB::table('activity_user')->insert([
            'user_id'     => 1,
            'activity_id' => 1,
            'status'      => 'booked',
            'created_at'  => now()->format('Y-m-d H:i:s'),
            'updated_at'  => now()->format('Y-m-d H:i:s'),
        ]);

        $response = $this->bookingsClient->unbook($this->encode(1), $this->encode(1));

        $response->assertException([
            'status' => 409,
        ]);
    }

    /** @test */
    public function a_user_can_be_force_unbooked_from_an_activity_anytime_before_the_activity_starts()
    {
        DB::table('activity_user')->insert([
            'activity_id' => 1,
            'user_id'     => 1,
            'status'      => 'booked',
        ]);

        $response = $this->bookingsClient->unbook($this->encode(1), $this->encode(1), true);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('activity_user', [
            'activity_id' => 1,
            'user_id'     => 1,
        ]);
    }

    /** @test */
    public function it_returns_a_success_response_if_the_user_isnt_already_booked()
    {
        $response = $this->bookingsClient->unbook($this->encode(1), $this->encode(1), true);

        $response->assertSuccessful();
    }
}
