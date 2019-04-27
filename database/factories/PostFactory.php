<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->create(),
        'title' => $faker->sentence,
        'content' => implode("\n", $faker->sentences(3)),
    ];
});
