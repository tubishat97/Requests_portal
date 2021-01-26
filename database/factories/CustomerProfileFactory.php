<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use App\Models\CustomerProfile;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

$factory->define(CustomerProfile::class, function (Faker $faker) {


    $faker->addProvider(new Xvladqt\Faker\LoremFlickrProvider($faker));

    $filepath_customer = public_path('storage/customer');
    if (!File::exists($filepath_customer)) {
        File::makeDirectory($filepath_customer, 0777, true);
    }

    return [
        'customer_id' => factory(Customer::class)->create()->id,
        'fullname' => $faker->lastName.' '.$faker->firstName,
        'email' => $faker->boolean(50) ? $faker->email : null,
        'image' => $faker->boolean(50) ? 'customer/' . $faker->image($filepath_customer, 300, 300, ['people'], false) : null,
        'mobile' => '96279' . rand(0000000, 9999999),
        'birthdate' => ($faker->boolean(50)) ? $faker->date() : null,
        'device_id' =>Str::random(10),
        'is_active' => true,
    ];
});
