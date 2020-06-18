<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


$factory->define(Product::class, function (Faker $faker) {
    $title = $faker->sentence(4);
    return [
        'name' => $title,
        'url' => Str::slug($title),
        'category_id' => rand(1,20),
        'code' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'cost_price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
        'description' => $faker->text(60),
        'stock' => rand(50, 100),
        'margin_gain_u' => 50,
        'divisa_unit' => rand(1,10),
        'wholesale_quantity' => rand(50, 100),
        'margin_gain_w' => 25,
        'wholesale_divisa' => rand(1,10),
        'status' => 1,


    ];
});
