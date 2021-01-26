<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\UserProfile;
use Faker\Generator as Faker;

$factory->define(UserProfile::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birthdate' => ($faker->boolean(50)) ? $faker->date() : null,
        'is_active' => true,
    ];
});
