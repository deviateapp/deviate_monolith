<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Deviate\Usergroups\Models\Eloquent\Permission;
use Deviate\Usergroups\Models\Eloquent\PermissionSection;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker, array $attributes = []) {
    return [
        'permission_section_id' => function () {
            return factory(PermissionSection::class)->create()->id;
        },
        'permission_key'        => implode('.', $faker->words(2)),
        'name'                  => $faker->words(3, true),
        'description'           => $faker->paragraph,
        'is_ownable'            => $faker->boolean(25),
    ];
});
