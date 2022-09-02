<?php
namespace Ltreu\MyHabr\Blog;

use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\User;


class Like 
{
    private UUID $id;
    private UUID $idPost;
    private UUID $idUser;

    public function __construct( UUID $id,Post $idPost, User $idUser  )
    {
        $this->id = $id;
        $this->idPost = $idPost->uuid();
        $this->idUser = $idUser->uuid();
    } 

    /**
     * Get the value of id
     */
    public function getId(): UUID
    {
        return $this->id;
    }



    /**
     * Get the value of idPost
     */
    public function getIdPost(): UUID
    {
        return $this->idPost;
    }

    /**
     * Get the value of idUser
     */
    public function getIdUser(): UUID
    {
        return $this->idUser;
    }
}