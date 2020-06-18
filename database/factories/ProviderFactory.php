<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Provider;
use Faker\Generator as Faker;

$factory->define(Provider::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'customer_id' => rand(1,25),  
        'name' => $name,
        'contact_phone' => $faker->tollFreePhoneNumber,
        'url' => str_slug($name),
    ];
});
