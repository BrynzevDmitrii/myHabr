<?php

namespace Ltreu\MyHabr\Blog;

use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\User;


class Comment {
    private int $id;
    private int $idAuthor;
    private int $idPost;
    private string $textComment;
    
    public function __construct($id,Post $idAuthor, Post $idPost, $textComment )
    {
        $this->id = $id;
        $this->idAuthor = $idAuthor->autor_uuid();
        $this->idPost = $idPost->uuid();
        $this->textComment = $textComment;
    }

    /**
     * Get the value of idComment
     */
    public function getIdComment(): int
    {
        return $this->id;
    }

    /**
     * Get the value of idAuthor
     */
    public function getIdAuthor(): UUID
    {
        return $this->idAuthor;
    }

    /**
     * Get the value of textComment
     */
    public function getTextComment(): string
    {
        return $this->textComment;
    }

    public function __toString()
    {
        return 'коментарий :' . $this->textComment;
    }

    /**
     * Get the value of idPost
     */
    public function getIdPost(): int
    {
        return $this->idPost;
    }
}