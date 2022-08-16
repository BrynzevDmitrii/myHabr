<?php
namespace Ltreu\MyHabr\tests\PostTest;

use PDO;
use PDOStatement;
use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\Name;
use Ltreu\MyHabr\Persons\User;
use PHPUnit\Framework\TestCase;
use Ltreu\MyHabr\Blog\Repositories\PostRepository;
use Ltreu\MyHabr\Exceptions\AutorNotFoundException;

class PostsRepositoryTest extends TestCase 
{
    public function testItThrowsAnExceptionWhenPostNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementStub = $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);

         $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new PostRepository($connectionStub);

        $this->expectException(AutorNotFoundException::class);
         $this->expectExceptionMessage('Cannot find autor: Ivan');

         $repository->getPostTitle('Ivan');
    }


    public function testItSavesPostToDatabase(): void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock
        ->expects($this->once()) 
        ->method('execute') 
        ->with([ 
        ':uuid' => '123e4567-e89b-12d3-a456-426614174000',
        ':autor_uuid' => '7f2ddf90-81d1-4a2f-80dd-98e8801f6ee2',
        ':title' => 'Perfect HTML',
        ':text' => 'Whether it is PSD to HTML/Drupal/Magento/WordPress.'
        ]);

        $connectionStub->method('prepare')->willReturn($statementMock);


        $repository = new PostRepository($connectionStub);

        $mockUser = new User(new UUID('7f2ddf90-81d1-4a2f-80dd-98e8801f6ee2'), 
        'ivan123',
        new Name('Ivan', 'Nikitin'));

        $repository->save (
            new Post(
            new UUID('123e4567-e89b-12d3-a456-426614174000'),
            $mockUser,
            'Perfect HTML',
            'Whether it is PSD to HTML/Drupal/Magento/WordPress.'
            ));
            
    }


}