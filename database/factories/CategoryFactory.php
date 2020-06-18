<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $title = $faker->sentence(3);
    return [
        'name' => $title,
        'url' => Str::slug($title),
        'description' => $faker->text(60),
        'status'=>1,
    ];
});
