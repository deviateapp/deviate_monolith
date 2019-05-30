<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Deviate\Users\Models\Eloquent\Avatar;
use Deviate\Users\Models\Eloquent\User;
use Faker\Generator as Faker;
use Hashids\HashidsInterface;
use Illuminate\Http\UploadedFile;

$factory->define(Avatar::class, function (Faker $faker, array $attributes = []) {
    /** @var HashidsInterface $hashids */
    $hashids = app(HashidsInterface::class);

    $user = array_key_exists('user_id', $attributes)
        ? User::find($attributes['user_id'])
        : factory(User::class)->create();

    $encodedUserId = $hashids->encode($user['id']);

    $path = UploadedFile::fake()->image('avatar.jpg', 80, 80)->store($encodedUserId);

    return [
        'organisation_id' => $user['organisation_id'],
        'user_id'         => $attributes['user_id'],
        'path'            => $path,
    ];
});
