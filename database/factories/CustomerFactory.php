<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'name' => $name,
        'url' => Str::slug($name),
        'type_document' => $faker->randomElement($array = array ('V','E','J')),
        'num_document' => $faker->numberBetween($min = 10000000, $max = 30900000),
        'address' => $faker->address,
        'num_phone' => $faker->tollFreePhoneNumber,
        'email' => $faker->email,
    ];
});
