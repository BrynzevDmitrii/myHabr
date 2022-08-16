<?php
namespace Ltreu\MyHabr\Blog\Repositories;



use PDO;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\Name;
use Ltreu\MyHabr\Persons\User;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Exceptions\InvalidArgumentException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\UsersRepositoryInterface;





class UserRepository implements UsersRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection ) 
    {
        $this->connection = $connection;
    }
        
    public function save (User $user) : void 
    {
        $statement = $this->connection->prepare (
           'INSERT INTO users (uuid,username, first_name, last_name)
           VALUES (:uuid, :username, :first_name, :last_name)'
        );

        $statement->execute([
            ':uuid' =>(string)$user-> uuid(),
            ':username'=>$user->username(),
            ':first_name' => $user->name()->first(),
            ':last_name' => $user->name()->last()
            ]);
            
    }

    public function get($uuid):User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE uuid = :uuid'
            );
            $statement->execute([
            ':uuid' => (string)$uuid,
            ]);
            return $this->getUser($statement, $uuid);
    }

    public function getByUsername(string $username): User
    {
        $statement = $this->connection->prepare(
        'SELECT * FROM users WHERE username = :username'
        );

        $statement->execute([
        ':username' => $username,
        ]);
        return $this->getUser($statement, $username);
    }

    private function getUser( $statement, string $username): User
    {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            if (false === $result) {
            throw new UserNotFoundException(
            "Cannot find user: $username"
            );
        }

    return new User(
        
        new UUID($result['uuid']),
        $result['username'],
        new Name($result['first_name'], $result['last_name'])
        );

    }


}