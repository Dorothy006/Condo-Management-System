<?php

use Faker\Generator as Faker;

$factory->define(App\Mailbox::class, function (Faker $faker) {
    return [
        //
        'available' => 0
    ];
});
