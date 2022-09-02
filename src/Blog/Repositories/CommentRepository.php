<?php
namespace Ltreu\MyHabr\Blog\Repositories;

use PDO;
use Ltreu\MyHabr\Blog\UUID;
use Psr\Log\LoggerInterface;
use Ltreu\MyHabr\Blog\Comment;
use Ltreu\MyHabr\Exceptions\IdNotFoundException;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\CommentsRepositoryInterface;

class CommentRepository implements CommentsRepositoryInterface
{
    private PDO $connection;
    private LoggerInterface $logger;

    public function __construct(PDO $connection, LoggerInterface $logger ) 
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
            ':uuid' =>(string)$textComment->getIdComment(),
            ':post_uuid'=>$textComment->getIdPost(),
            ':autor_uuid' => $textComment->getIdAuthor(),
            ':text' => $textComment->getTextComment()
            ]);

            $uuid = $statemant->fetch(PDO::FETCH_ASSOC);

            $this->logger->info("Post created :" {$textComment->getIdComment()});   
    }

    public function get(UUID $id):Comment
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM comments WHERE uuid = :uuid'
            );
            $statement->execute([
            ':uuid' => (string)$id,
            ]);
            return $this->getComments($statement, $id);
    }

    private function getComments( $statement, string $id): Comment
    {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
           
            if (false === $result) {

                $massage = "Cannot find autor: $uuid";

                $this->logger->warning($massage);

                throw new IdNotFoundException($massage);
        }

    return new Comment(
        
        new UUID($result['uuid']),
        $result['post_uuid'],
        $result['autor_uuid'],
        $result['text']
        );

    }
    
    public function getText(string $idPost): bool
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM comments WHERE post_uuid = :post_uuid'
            );
    
            $statement->execute([
            ':post_uuid' => $idPost,
            ]);
            return $this->getComments($statement, $idPost);
    }

}