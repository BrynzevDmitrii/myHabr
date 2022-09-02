<?php

use PDO;
use Dotenv\Dotenv;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;
use Ltreu\MyHabr\Blog\Container\DIContainer;
use Ltreu\MyHabr\Blog\Repositories\LikeRepository;
use Ltreu\MyHabr\Blog\Repositories\PostRepository;
use Ltreu\MyHabr\Blog\Repositories\UserRepository;
use Ltreu\MyHabr\Blog\Repositories\CommentRepository;
use Ltreu\MyHabr\Blog\Repositories\Interfaces\LikesRepositoryInterface;
use Ltreu\MyHabr\Blog\Repositories\interfaces\PostsRepositoryInterface;
use Ltreu\MyHabr\Blog\Repositories\interfaces\UsersRepositoryInterface;
use Ltreu\MyHabr\Blog\Repositories\interfaces\CommentsRepositoryInterface;


require_once __DIR__ . '/vendor/autoload.php';

Dotenv::createImmutable(__DIR__)->safeLoad();

$container = new DIContainer();

$logger = (new Logger('blog'));

$container->bind(
    PDO::class,
    new PDO('sqlite:' . __DIR__ . $_SERVER['SQLITE_DB_PATH'])
);

$container->bind(
    PostsRepositoryInterface::class,
    PostRepository::class
);

$container->bind(
    UsersRepositoryInterface::class,
    UserRepository::class
);

$container->bind(
    CommentsRepositoryInterface::class,
    CommentRepository::class
);

$container->bind(
     LikesRepositoryInterface::class,
    LikeRepository::class
 );

 $container->bind(
    IdentificationInterface::class,
    JsonBodyUuidIdentification::class
    );

 
    
    if('yes'===$_SERVER('LOG_TO_FILES')){
        $container->bind(
        LoggerInterface::class,
        $logger->pushHandler(new StreamHandler(__DIR__ . '/logs/blog.log'))->pushHandler(
            new StreamHandler(
                __DIR__ . '/logs/blog.error.log',
                level: Logger::ERROR,
                bubble: false,
                )
            )
        );
    }
    

 if ('yes' === $_SERVER['LOG_TO_CONSOLE']) {
    $logger
    ->pushHandler(
    new StreamHandler("php://stdout")
    );
    }
    $container->bind(
    LoggerInterface::class,
    $logger
    );
    


return $container;
