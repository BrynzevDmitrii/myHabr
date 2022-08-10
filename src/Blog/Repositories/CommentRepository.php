<?php
namespace Ltreu\MyHabr\Blog\Repositories;

use PDO;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Blog\Comment;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\CommentsRepositoryInterface;

class CommentRepository implements CommentsRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection ) 
    {
        $this->connection = $connection;
    }
        
    public function save (Comment $textComment) : void 
    {
        $statement = $this->connection->prepare (
           'INSERT INTO comments (uuid, post_uuid, autor_uuid, text)
           VALUES (:uuid, :post_uuid, :autor_uuid, :text)'
        );

        $statement->execute([
            ':uuid' =>(string)$textComment->uuid(),
            ':post_uuid'=>$textComment->getIdPost(),
            ':autor_uuid' => $textComment->getIdAuthor(),
            ':text' => $textComment->getTextComment()
            ]);
            
    }

    public function get(UUID $id):Comment
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM comments WHERE  = uuid :uuid'
            );
            $statement->execute([
            ':uuid' => (string)$id,
            ]);
            return $this->getComments($statement, $id);
    }

    private function getComments( $statement, string $id): Post
    {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            if (false === $result) {
            throw new UserNotFoundException(
            "Cannot find autor: $id"
            );
        }

    return new Comment(
        
        new UUID($result['uuid']),
        $result['post_uuid'],
        $result['autor_uuid'],
        $result['text']
        );

    }


}