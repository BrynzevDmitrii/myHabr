<?php
namespace Ltreu\MyHabr\Blog\Repositories\Interfaces;

use Ltreu\MyHabr\Blog\Like;
use Ltreu\MyHabr\Blog\UUID;

interface LikesRepositoryInterface {
    public function getByPostUuid (UUID $idPost):array;
    public function save (Like $uuidUser) : void;
}