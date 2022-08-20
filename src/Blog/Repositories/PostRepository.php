<?php 
namespace Ltreu\MyHabr\Blog\Repositories;

use PDO;
use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\Name;
use Ltreu\MyHabr\Persons\User;
use Ltreu\MyHabr\Exceptions\AutorNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\Interfaces\PostsRepositoryInterface;



class PostRepository implements PostsRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection ) 
    {
        $this->connection = $connection;
    }
        
    public function save (Post $post ) : void 
    {
        $statement = $this->connection->prepare (
           'INSERT INTO posts (uuid, autor_uuid, title, text)
           VALUES (:uuid, :autor_uuid, :title, :text)'
        );

        $statement->execute([
            ':uuid' =>(string)$post->uuid(),
            ':autor_uuid'=>$post->autor_uuid(),
            ':title' => $post->getTitle(),
            ':text' => $post->getText()
            ]);
            
    }

    public function get(UUID $autor_uuid):Post
    {
        $statement = $this->connection->prepare(
            'SELECT *
            FROM posts LEFT JOIN users
                   ON posts.autor_uuid = users.uuid 
                   WHERE posts.autor_uuid = :uuid'
            );
            $statement->execute([
            ':uuid' => (string)$autor_uuid,
            ]);
            return $this->getPost($statement, $autor_uuid);
    }

    public function getPostToUuidPost(UUID $post_uuid):Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM posts, users WHERE   posts.uuid = :post_uuid'
            );
            $statement->execute([
            ':post_uuid' => (string)$post_uuid,
            ]);
            return $this->getPost($statement, $post_uuid);
    }

    private function getPost( $statement, string $uuid): Post
    {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            if (false === $result) {
            throw new AutorNotFoundException(
            "Cannot find autor: $uuid"
            );
        }

        $user = new User(
            new UUID($result['autor_uuid']),
            $result['username'],
            new Name($result['first_name'], $result['last_name'])
        );
        print_r($result);

   
        return new Post(
            new UUID($result['uuid']),
            $user,
            $result['title'], 
            $result['text']
            );

    }

    public function getPostTitle(string $titlePost): Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM posts WHERE title = :title'
            );
    
            $statement->execute([
            ':title' => $titlePost,
            ]);
            return $this->getPost($statement, $titlePost);
    }



}