<?php 
namespace Ltreu\MyHabr\Blog\Repositories;

use PDO;
use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Blog\Repositories\interfaces\PostsRepositoryInterface;



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
            'SELECT * FROM posts WHERE  = autor_uuid :autor_uuid'
            );
            $statement->execute([
            ':autor_uuid' => (string)$autor_uuid,
            ]);
            return $this->getPost($statement, $autor_uuid);
    }

    private function getPost( $statement, string $autor_uuid): Post
    {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            if (false === $result) {
            throw new UserNotFoundException(
            "Cannot find autor: $autor_uuid"
            );
        }

    return new Post(
        
        new UUID($result['uuid']),
        $result['autor_uuid'],
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