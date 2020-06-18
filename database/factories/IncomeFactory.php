<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Income;
use Faker\Generator as Faker;

$factory->define(Income::class, function (Faker $faker) {
    return [
        'provider_id' => rand(1,25),
        'user_id' => 1,
        'type_vaucher' => $faker->randomElement($array = array ('Factura','Nota')),
        'num_vaucher' => $faker->numberBetween($min = 1000000, $max = 9000000),
        'num_bill' => $faker->numberBetween($min = 1000000, $max = 9000000),
        'tax' => 16,
        'total' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
        'status' => 'PAGADO',
    ];
});
