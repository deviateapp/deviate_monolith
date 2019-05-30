<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Deviate\Organisations\Models\Eloquent\Organisation;
use Deviate\Usergroups\Models\Eloquent\Usergroup;
use Faker\Generator as Faker;

$factory->define(Usergroup::class, function (Faker $faker) {
    return [
        'organisation_id' => function () {
            return factory(Organisation::class)->create()->id;
        },
        'name'            => $faker->unique()->words(3, true),
        'description'     => $faker->paragraph,
        'is_supergroup'   => false,
    ];
});

$factory->state(Usergroup::class, 'supergroup', [
    'is_supergroup' => true,
]);
