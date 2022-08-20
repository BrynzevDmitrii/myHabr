<?php

require_once __DIR__ .'/vendor/autoload.php';

use PDO;
use Ltreu\MyHabr\HTTP\Request;
use Ltreu\MyHabr\HTTP\ErrorResponse;
use Ltreu\MyHabr\Exceptions\AppException;
use Ltreu\MyHabr\HTTP\SuccessfulResponse;
use Ltreu\MyHabr\Exceptions\HttpException;
use Ltreu\MyHabr\HTTP\Actions\ActionInterface;
use Ltreu\MyHabr\HTTP\Actions\Posts\CreatePost;
use Ltreu\MyHabr\Blog\Repositories\PostRepository;
use Ltreu\MyHabr\Blog\Repositories\UserRepository;
use Ltreu\MyHabr\HTTP\Actions\Users\FindByUsername;
use Ltreu\MyHabr\HTTP\Actions\Comment\CreateComment;
use Ltreu\MyHabr\Blog\Repositories\CommentRepository;



$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));


try {
   
    $path = $request->path();
    
    }
     catch (HttpException) {
    
    (new ErrorResponse('Not path'))->send();
    return;
    }

    try {
        $method = $request->method();
        } catch (HttpException) {
        (new ErrorResponse('Not method'))->send();
        return;
        }

    $routes = [
        'GET'=> [
            '/users/show' => new FindByUsername(
            new UserRepository(
            new PDO('sqlite:' . __DIR__ . '/blog.sqlite'))),
            ],


         'POST' => [

        '/posts/create' => new CreatePost(
        new PostRepository(
        new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
        ),

        new UserRepository(
        new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
        )
        ),

        '/comment/create'=> new CreateComment(
            new PostRepository(
                new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
                ),
        
                new CommentRepository(
                new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
                )
        )
        ]
            
    ];

    

    if (!array_key_exists($method, $routes)) {
        (new ErrorResponse('Not found'))->send();
        return;
        }
        

    if (!array_key_exists($path, $routes[$method])) {
        (new ErrorResponse('Not rout[method]'))->send();
        return;
        }
        
    $action = $routes[$method][$path];

    try {

    $response = $action->handle($request);
    } catch (AppException $e) {
    
    (new ErrorResponse($e->getMessage()))->send();
    }

    $response->send();
    