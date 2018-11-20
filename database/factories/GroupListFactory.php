<?php

use Faker\Generator as Faker;

$factory->define(App\GroupList::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->name,
        'id' => random_int(1,5),
    ];
});
