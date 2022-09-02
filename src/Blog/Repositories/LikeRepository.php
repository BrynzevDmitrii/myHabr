<?php
namespace Ltreu\MyHabr\Blog\Repositories;

use PDO;
use Ltreu\MyHabr\Blog\Like;
use Ltreu\MyHabr\Blog\UUID;
use Psr\Log\LoggerInterface;
use Ltreu\MyHabr\Exceptions\LikeException;
use Ltreu\MyHabr\Blog\Repositories\Interfaces\LikesRepositoryInterface;


class LikeRepository implements LikesRepositoryInterface
{
    private PDO $connection;
    private LoggerInterface $logger;

    public function __construct(PDO $connection, LoggerInterface $logger ) 
    {
        $this->connection = $connection;
    }
        
    public function save (Like $like ) : void 
    {

         if($this->countLikesUserOnePost($like) == 1){
             throw new LikeException("User has already liked this article ");
          }else{
        $statement = $this->connection->prepare (
            'INSERT INTO Likes(uuid,post_uuid, user_uuid)
            VALUES (:uuid, :post_uuid, :user_uuid)'
         );
 
         $statement->execute([
             ':uuid' =>(string)$like->getId(),
             ':post_uuid'=>$like->getIdPost(),
             ':user_uuid' => $like->getIdUser(),
             ]);
              }

              $this->logger->info ("Like created:" {$like->getId()});

    }

    public function getByPostUuid(UUID $idPost):array
    {

        $statement = $this->connection->prepare(
            'SELECT user_uuid FROM Likes WHERE post_uuid = :uuid'
            );
            $statement->execute([
            ':uuid' => (string)$idPost,
            ]);
            return $this->getlikes($statement, (string)$idPost);
    }
    

    private function getlikes( $statement, string $idPost): array
    {  
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            if (false === $result) {

                $massage = "Cannot find post: $idPost";

                $this->logger->warning($massage);

            throw new PostNotFoundException($massage);
        }
    
    return $result;
    
    }

    private function countLikesUserOnePost(Like $like): bool|null
    {
        $usersId = $this->getByPostUuid($like->getIdPost());
        foreach($usersId as $key=>$value){
            foreach ($value as $keys ) 
            {
                $usersArray[] =  $keys;
                $checed = in_array($like->getIdUser(),$usersArray);
            }
           
        }
        return $checed;
            
    }
}