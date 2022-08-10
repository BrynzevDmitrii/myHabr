<?php 
namespace Ltreu\MyHabr\Blog\Commands;

use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\Name;
use Ltreu\MyHabr\Persons\User;
use Ltreu\MyHabr\Blog\Commands\Arguments;
use Ltreu\MyHabr\Exceptions\CommandException;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\UsersRepositoryInterface;

 


 class CreateUsersCommand 
 {
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function handle(Arguments $arguments): void
    {
        $username = $arguments->get('username');
    if ($this->userExists($username)) {
        throw new CommandException("User already exists: $username");
    }
        $this->usersRepository->save(new User(
            UUID::random(),
            $arguments->get('username'),
            new Name($arguments->get('first_name'), $arguments->get('last_name'))
            ));
        
    }
        
    private function userExists(string $username): bool
    {
    try {
        $this->usersRepository->getByUsername($username);
    } catch (UserNotFoundException) {
        return false;
    }
        return true;
    }



 }