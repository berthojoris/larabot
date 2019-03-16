<?php

use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'description' => $faker->realText(rand(80, 600)),
    ];
});
