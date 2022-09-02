<?php

require_once __DIR__ . '/vendor/autoload.php'; 


use Psr\Log\LoggerInterface;
use Ltreu\MyHabr\Blog\Commands\Arguments;
use Ltreu\MyHabr\Exceptions\AppException;
use Ltreu\MyHabr\Blog\Commands\CreateLikeCommand;
use Ltreu\MyHabr\Blog\Commands\CreatePostsCommand;
use Ltreu\MyHabr\Blog\Commands\CreateUsersCommand;
use Ltreu\MyHabr\Blog\Repositories\PostRepository;
use Ltreu\MyHabr\Blog\Repositories\UserRepository;
use Ltreu\MyHabr\Blog\Commands\CreateCommetsCommand;
use Ltreu\MyHabr\Blog\Repositories\CommentRepository;


$container = require __DIR__ . '/bootstrap.php';



$logger = $container->get(LoggerInterface::class);
 $command = $container->get(CreateUsersCommand::class);

 $command = $container->get(CreatePostsCommand::class);

 $command = $container->get(CreateCommetsCommand::class);

 $command = $container->get(CreateLikeCommand::class);


try {
    $command = $container->get(CreateUsersCommand::class);
    $command->handle(Arguments::fromArgv($argv));
    } catch (Exception $e) {
        $logger->error($e->getMessage(), ['exception' => $e]);
    }
   