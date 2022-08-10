<?php
namespace Ltreu\MyHabr\Blog\Repositories\interfaces;


use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Blog\Comment;

interface  CommentsRepositoryInterface {
    public function get(UUID $id):Comment;
    public function save (Comment $textComment) : void;
    public function getText(string $commentText): bool;
}