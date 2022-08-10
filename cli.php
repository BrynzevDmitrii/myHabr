<?php

require_once __DIR__ . '/vendor/autoload.php'; 


use PDO;
use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\User;
use Ltreu\MyHabr\Blog\Commands\Arguments;
use Ltreu\MyHabr\Blog\Commands\CreateUsersCommand;
use Ltreu\MyHabr\Blog\Repositories\PostRepository;
use Ltreu\MyHabr\Blog\Repositories\UserRepository;




$PostRepository = new PostRepository(
    new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
    );

$usersRepository = new UserRepository(
        new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
        );
   

// $command = new CreateUsersCommand($PostRepository);
$user = $usersRepository->getByUsername('Dmitriy');
try {
     $PostRepository->save(new Post(UUID::random(),$users, 'TREEER' , 'eujhjeeujhv iehhve hiueh heu euh ue u'));
    //$command->handle(( Arguments::fromArgv($argv)));
//    print $user;
    } catch (CommandException) {
        echo "cli_error";
    };
   
