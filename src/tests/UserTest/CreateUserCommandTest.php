<?php
namespace Ltreu\MyHabr\tests;

use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\User;
use PHPUnit\Framework\TestCase;
use Ltreu\MyHabr\Blog\Commands\Arguments;
use Ltreu\MyHabr\Exceptions\CommandException;
use Ltreu\MyHabr\Exceptions\ArgumentsException;
use Ltreu\MyHabr\Blog\Commands\CreateUsersCommand;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\DummyUsersRepository;
use Ltreu\MyHabr\Blog\Repositories\interfaces\UsersRepositoryInterface;


class CreateUserCommandTest extends TestCase 
{

    public function testItRequiresUserName(): void 
    {
        $command = new CreateUsersCommand(new DummyUsersRepository());

        $this->expectException(CommandException :: class);
        
        $this->expectExceptionMessage('User already exists: Ivan');

        $command->handle(new Arguments(['username' => 'Ivan']));
    }
    

    public function testItRequiresFirstName(): void 
    {
        $userRepository = new class implements UsersRepositoryInterface
        {
            public function save(User $user):void
            {

            }

            public function get(UUID $uuid): User
            {
            throw new UserNotFoundException("Not found");
            }


            public function getByUsername(string $username): User
            {
            throw new UserNotFoundException("Not found");
            }
        };

            $command = new CreateUsersCommand($userRepository);

            $this->expectException(ArgumentsException::class);

            $this->expectExceptionMessage('No such argument: username');

            $command->handle(new Arguments(['first_name' => 'Ivan']));
        
    }
}