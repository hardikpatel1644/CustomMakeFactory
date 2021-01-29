<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'first_name' => $faker->word,
		'last_name' => $faker->word,
		'email' => $faker->word,
		'age' => $faker->number,
		'date_of_birth' => $faker->date,
		'status' => $faker->boolean,
		
    ];
});
