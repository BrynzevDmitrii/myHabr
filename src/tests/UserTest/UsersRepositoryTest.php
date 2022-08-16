<?php 
namespace Ltreu\MyHabr\tests\UserTest;

use PDO;
use PDOStatement;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\Name;
use Ltreu\MyHabr\Persons\User;
use PHPUnit\Framework\TestCase;
use Ltreu\MyHabr\Blog\Repositories\UserRepository;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;

class UsersRepositoryTest extends TestCase
{
    public function testItThrowsAnExceptionWhenUserNotFound(): void
    {
        
            $connectionStub = $this->createStub(PDO::class);

            $statementStub = $this->createStub(PDOStatement::class);

            $statementStub->method('fetch')->willReturn(false);

            $connectionStub->method('prepare')->willReturn($statementStub);

            $repository = new UserRepository($connectionStub);

            $this->expectException(UserNotFoundException::class);
            $this->expectExceptionMessage('Cannot find user: Ivan');


            $repository->getByUsername('Ivan');

    }

    public function testItSavesUserToDatabase(): void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock
        ->expects($this->once()) // Ожидаем, что будет вызван один раз
        ->method('execute') // метод execute
        ->with([ // с единственным аргументом - массивом
        ':uuid' => '123e4567-e89b-12d3-a456-426614174000',
        ':username' => 'ivan123',
        ':first_name' => 'Ivan',
        ':last_name' => 'Nikitin',
        ]);

        $connectionStub->method('prepare')->willReturn($statementMock);


        $repository = new UserRepository($connectionStub);

        $repository->save (
            new User(
            new UUID('123e4567-e89b-12d3-a456-426614174000'),
            'ivan123',
            new Name('Ivan', 'Nikitin')
            ));
            
    }

    
}