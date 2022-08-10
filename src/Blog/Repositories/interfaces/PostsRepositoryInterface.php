<?php
namespace Ltreu\MyHabr\Blog\Repositories\interfaces;


use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\User;

interface  PostsRepositoryInterface {
    public function get(UUID $autor_uuid):Post;
    public function save (Post $titlePost) : void;
    public function getPostTitle(string $titlePost): Post;

    
}