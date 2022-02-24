<?php

require_once 'vendor/autoload.php';

use App\User\User;
use App\Comment\Comment;
use App\Post\Post;

$faker = Faker\Factory::create();

switch ($argv[1]) {
    case 'User':
        echo new User($faker->unique()->randomDigit, $faker->firstName, $faker->lastName);
        break;
    case 'Post':
        echo new Post($faker->unique()->randomDigit, $faker->unique()->randomDigit, $faker->text(rand(50, 100)), $faker->text(rand(150, 500)));
        break;
    case 'Comment':
        echo new Comment($faker->unique()->randomDigit, $faker->unique()->randomDigit, $faker->unique()->randomDigit, $faker->text(rand(50, 200)));
}
