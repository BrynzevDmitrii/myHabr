<?php

require_once __DIR__ . '/vendor/autoload.php'; 

use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Persons\User;
use Ltreu\MyHabr\Blog\Comment;

$user = Faker\Factory :: create();

$argv = new User(
        10,
        $user->name ()
);

$post = new Post(
    1,
    $argv,
    'Это заголовок пробного поста', 
    'Ну а это текст поста ...'
);

$comment = new Comment(
    3,
    $argv,
    $post,
    'текст коммента'
);

print $comment;