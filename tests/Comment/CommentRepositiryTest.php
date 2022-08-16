<?php
namespace Ltreu\MyHabr\tests\Comment;

use PDO;
use PDOStatement;
use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Blog\Comment;
use Ltreu\MyHabr\Persons\Name;
use Ltreu\MyHabr\Persons\User;
use PHPUnit\Framework\TestCase;
use Ltreu\MyHabr\Exceptions\IdNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\CommentRepository;

class CommentRepositiryTest extends TestCase 
{
    public function testItThrowsAnExceptionWhenCommentNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementStub = $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);

         $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new CommentRepository($connectionStub);

        $this->expectException(IdNotFoundException::class);
         $this->expectExceptionMessage('Cannot find autor: 55890f6d-87e3-44ef-a6b7-144fc8acb2dd');

         $repository->getText('55890f6d-87e3-44ef-a6b7-144fc8acb2dd');

    }

    public function testItSavesCommentToDatabase(): void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock
        ->expects($this->once()) 
        ->method('execute') 
        ->with([ 
        ':uuid' => '123e4567-e89b-12d3-a456-426614174000',
        ':autor_uuid' => '7f2ddf90-81d1-4a2f-80dd-98e8801f6ee2',
        ':post_uuid' =>'2a4cd27d-cec1-4a94-a77d-a343f487ca4e' ,
        ':text' => 'TextComment'
        ]);

        $connectionStub->method('prepare')->willReturn($statementMock);


        $repository = new CommentRepository($connectionStub);

        $mockUser = new User(
            new UUID('7f2ddf90-81d1-4a2f-80dd-98e8801f6ee2'), 
           'ivan123',
            new Name('Ivan', 'Nikitin')
        );

        $mockPost = new Post(
            new UUID ('2a4cd27d-cec1-4a94-a77d-a343f487ca4e'),
             $mockUser, 
             'title',
            'description'
            );


        $repository->save (
            new Comment (
            new UUID('123e4567-e89b-12d3-a456-426614174000'),
            $mockPost,
            $mockPost,
            'TextComment',
            ));
            
    }


}