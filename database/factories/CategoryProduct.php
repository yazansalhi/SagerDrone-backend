<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CategoryProduct;
use Faker\Generator as Faker;

$factory->define(App\CategoryProduct::class, function (Faker $faker) {
    return [
        'category_id' => factory(App\Category::class)->create()->id,
        'product_id' => factory(App\Product::class)->create()->id,
    ];
});