<?php

require_once __DIR__ . '/vendor/autoload.php'; 


use PDO;
use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Blog\Comment;
use Ltreu\MyHabr\Persons\Name;
use Ltreu\MyHabr\Persons\User;
use Ltreu\MyHabr\Blog\Commands\Arguments;
use Ltreu\MyHabr\Blog\Commands\CreateUsersCommand;
use Ltreu\MyHabr\Blog\Repositories\PostRepository;
use Ltreu\MyHabr\Blog\Repositories\UserRepository;
use Ltreu\MyHabr\Blog\Repositories\CommentRepository;




$comment = new CommentRepository(
    new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
    );

$usersRepository = new UserRepository(new PDO('sqlite:' . __DIR__ . '/blog.sqlite'));

// $user = $usersRepository->get('dc103cd9-1d62-47ef-b337-c87407f2b227');

$post = new PostRepository( new PDO('sqlite:' . __DIR__ . '/blog.sqlite'))  ;  

$newpost= new Post(new UUID ('55890f6d-87e3-44ef-a6b7-144fc8acb2dd'), new User(new UUID('7f2ddf90-81d1-4a2f-80dd-98e8801f6ee2'),'Dmitriy', new Name("Dmitriyl", "Kirin")),'TREEER', 'eujhjeeujhv iehhve hiueh heu euh ue u');
 
// $posts = $post->get($user->uuid());
     

$newcomment = new Comment(new UUID ( UUID::random()),$newpost, $newpost, "текст коммента" );

$comment->save($newcomment);