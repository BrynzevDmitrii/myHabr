<?php 
namespace Ltreu\MyHabr\Blog\Repositories;

use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\Name;
use Ltreu\MyHabr\Persons\User;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\UsersRepositoryInterface;



class DummyUsersRepository implements UsersRepositoryInterface
{
    public function save(User $user): void
{

}

public function get(UUID $uuid): User
{
throw new UserNotFoundException("Not found");
}


public function getByUsername(string $username): User
{
return new User(UUID::random(), "user123", new Name("first", "last"));
}

}