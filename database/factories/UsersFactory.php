<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Users::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'telegram' => $faker->word,
        'email' => $faker->email,
        'password' => $faker->password,
        'default_currency_id' => '1',
        'min_rank' => $faker->randomDigitNotNull,
        'rank' => $faker->randomDigitNotNull,
        'deals_count'  => $faker->randomDigitNotNull
    ];
});

