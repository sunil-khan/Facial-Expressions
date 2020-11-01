<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Book::class, function (Faker $faker) {
    $title = $faker->name;
    $random_no = rand(1,20);
    $book_no = rand(1,2);
    return [
        'book_title' => $title,
        'book_slug' => str_slug($title,'-'),
        'book_author_name' => $faker->name,
        'book_thumb' => "book$random_no.png",
        'book_file' => "book$book_no.pdf",
    ];
});
