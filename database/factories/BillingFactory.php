<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Billing::class, function (Faker $faker) {
    return [
        // 'user_id' => function () {
        //     return App\User::inRandomOrder()->first()->id;
        // },
        'user_id' => $faker->unique()->randomDigit,
        'bill' => $faker->randomNumber(6),
        'due_date' => Carbon::now(),
    ];
});
