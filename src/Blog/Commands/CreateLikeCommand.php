<?php
namespace Ltreu\MyHabr\Blog\Commands;

use Ltreu\MyHabr\Blog\Like;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Blog\Commands\Arguments;
use Ltreu\MyHabr\Exceptions\LikeException;
use Ltreu\MyHabr\Blog\Repositories\Interfaces\LikesRepositoryInterface;


class CreateLikeCommand 
 {
    private LikesRepositoryInterface $likeRepository;

    public function __construct(LikesRepositoryInterface $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function handle(Arguments $arguments): void
    {
        if($this->countLikesUserOnePost($arguments) == 1){
            throw new LikeException("User has already liked this article ");}
            else{
        $this->likeRepository->save(new Like(
            UUID::random(),
            $arguments->get('post_uuid'),
            $arguments->get('user_uuid'),
            ));
        }
        
    }
        
    private function countLikesUserOnePost(Arguments $arguments): bool
    {
        $usersId = $this->likeRepository->getByPostUuid(new UUID($arguments->get('post_uuid')));
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