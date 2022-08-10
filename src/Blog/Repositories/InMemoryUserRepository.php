<?php 
namespace Ltreu\MyHabr\Blog\Repositories;

use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\User;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\UsersRepositoryInterface;

class InMemoryUserRepository implements UsersRepositoryInterface
{
private array $users = [];

public function save(User $user): void
{
$this->users[] = $user;
}

public function get(UUID $uuid): User

{
    foreach ($this->users as $user) {

    if ((string)$user->uuid() === (string)$uuid) {
    return $user;
    }
    }

    throw new UserNotFoundException("User not found: $uuid");
    }

public function getByUsername(string $username): User
        {
            foreach ($this->users as $user) {
            if ($user->getFirstName() === $username) {
            return $user;
        }
        }
        
        throw new UserNotFoundException("User not found: $username");
        }
}
