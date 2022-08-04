<?php

namespace Ltreu\MyHabr\Blog;

use Ltreu\MyHabr\Persons\User;
use Ltreu\MyHabr\Blog\Post;


class Comment {
    private int $idComment;
    private int $idAuthor;
    private int $idPost;
    private string $textComment;
    
    public function __construct($id,User $idAuthor, Post $idPost, $textComment )
    {
        $this->id = $id;
        $this->idAuthor = $idAuthor->getId();
        $this->idPost = $idPost->getIdPost();
        $this->textComment = $textComment;
    }

    /**
     * Get the value of idComment
     */
    public function getIdComment(): int
    {
        return $this->idComment;
    }

    /**
     * Set the value of idComment
     */
    public function setIdComment(int $idComment): self
    {
        $this->idComment = $idComment;

        return $this;
    }

    /**
     * Get the value of idAuthor
     */
    public function getIdAuthor(): User
    {
        return $this->idAuthor;
    }

    /**
     * Set the value of idAuthor
     */
    public function setIdAuthor(User $idAuthor): self
    {
        $this->idAuthor = $idAuthor;

        return $this;
    }

    /**
     * Get the value of idPost
     */
    public function getIdPost(): Post
    {
        return $this->idPost;
    }

    /**
     * Set the value of idPost
     */
    public function setIdPost(Post $idPost): self
    {
        $this->idPost = $idPost;

        return $this;
    }

    /**
     * Get the value of textComment
     */
    public function getTextComment(): string
    {
        return $this->textComment;
    }

    /**
     * Set the value of textComment
     */
    public function setTextComment(string $textComment): self
    {
        $this->textComment = $textComment;

        return $this;
    }


    public function __toString()
    {
        return 'коментарий :' . $this->textComment;
    }
}