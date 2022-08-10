<?php 
namespace Ltreu\MyHabr\Blog\Repositories\interfaces;


use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\User;

interface UsersRepositoryInterface
{
public function save(User $user): void;
public function get(UUID $uuid): User;
public function getByUsername(string $username): User;
}
