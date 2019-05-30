<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Deviate\Usergroups\Models\Eloquent\PermissionSection;
use Faker\Generator as Faker;

$factory->define(PermissionSection::class, function (Faker $faker) {
    return [
        'name'        => $faker->unique()->words(2, true),
        'description' => $faker->paragraph,
    ];
});
