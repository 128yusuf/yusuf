<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'product_name' => $faker->name,
        'category' => rand(1,5),
        'description' => $faker->paragraph,
        'sub_category' => rand(1,5),
        'price' => rand(100,500),
        'image' => 'asasasas.jpg',
        'status' => true
    ];
});
