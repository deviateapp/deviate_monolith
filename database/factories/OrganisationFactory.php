<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Deviate\Organisations\Models\Eloquent\Organisation;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Organisation::class, function (Faker $faker) {
    $name = $faker->company;

    return [
        'name' => $name,
        'slug' => Str::slug($name),
    ];
});
