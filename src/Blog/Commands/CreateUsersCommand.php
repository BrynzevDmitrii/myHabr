<?php 
namespace Ltreu\MyHabr\Blog\Commands;

use Ltreu\MyHabr\Blog\UUID;
use Psr\Log\LoggerInterface;
use Ltreu\MyHabr\Persons\Name;
use Ltreu\MyHabr\Persons\User;
use Ltreu\MyHabr\Blog\Commands\Arguments;
use Ltreu\MyHabr\Exceptions\CommandException;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\UsersRepositoryInterface;


 


 class CreateUsersCommand 
 {
    private UsersRepositoryInterface $usersRepository;
    private LoggerInterface $logger;


    public function __construct(UsersRepositoryInterface $usersRepository , LoggerInterface $logger)
    {
        $this->usersRepository = $usersRepository;
        $this->logger = $logger;
    }

    public function handle(Arguments $arguments): void
    {

        $this->logger->info("Create user command started");

        $username = $arguments->get('username');
    if ($this->userExists($username)) {

        $this->logger->warning("User already exists: $username");
        
        return;
    }
        $this->usersRepository->save(new User(
            UUID::random(),
            $arguments->get('username'),
            new Name($arguments->get('first_name'), $arguments->get('last_name'))
            ));

            $this->logger->info("User created");
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