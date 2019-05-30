<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Deviate\Activities\Models\Eloquent\Activity;
use Deviate\Activities\Models\Eloquent\ActivityCollection;
use Deviate\Organisations\Models\Eloquent\Organisation;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker, array $attributes = []) {

    /** @var ActivityCollection $collection */
    $collection = array_key_exists('activity_collection_id', $attributes)
        ? ActivityCollection::find($attributes['activity_collection_id'])
        : factory(ActivityCollection::class)->create();

    $startsAt = $faker->dateTimeBetween($collection->activities_start_at, $collection->activities_end_at);

    return [
        'organisation_id'        => function () {
            return factory(Organisation::class)->create()->id;
        },
        'activity_collection_id' => $collection->id,
        'name'                   => $faker->words(3, true),
        'description'            => $faker->text(1000),
        'starts_at'              => $startsAt,
        'ends_at'                => $startsAt,
        'places'                 => ($faker->randomDigit+1)*10,
        'cost'                   => ($faker->randomDigit+1)*10,
    ];
});
