<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Carbon\Carbon;
use Deviate\Activities\Models\Eloquent\ActivityCollection;
use Deviate\Organisations\Models\Eloquent\Organisation;
use Faker\Generator as Faker;

$factory->define(ActivityCollection::class, function (Faker $faker, array $attributes = []) {
    $baseDate = array_key_exists('booking_starts_at', $attributes)
        ? Carbon::parse($attributes['booking_starts_at'])
        : Carbon::now()->endOfMonth()->addDay()->startOfDay();

    return [
        'organisation_id' => function () {
            return factory(Organisation::class)->create()->id;
        },
        'name' => $faker->words(2, true),
        'description' => $faker->paragraph,
        'booking_starts_at' => function () use ($baseDate) {
            return $baseDate->copy();
        },
        'booking_ends_at' => function () use ($baseDate) {
            return $baseDate->addDays(8)->endOfDay()->format('Y-m-d H:i:s');
        },
        'payment_starts_at' => function () use ($baseDate) {
            return $baseDate->addDays(1)->startOfDay()->format('Y-m-d H:i:s');
        },
        'payment_ends_at' => function () use ($baseDate) {
            return $baseDate->addDays(9)->endOfDay()->format('Y-m-d H:i:s');
        },
        'activities_start_at' => function () use ($baseDate) {
            return $baseDate->addDays(1)->startOfDay()->format('Y-m-d H:i:s');
        },
        'activities_end_at' => function () use ($baseDate) {
            return $baseDate->addDays(9)->endOfDay()->format('Y-m-d H:i:s');
        },
    ];
});
