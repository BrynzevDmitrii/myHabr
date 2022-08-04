<?php 

namespace Ltreu\MyHabr\Blog;
use Ltreu\MyHabr\Persons\User;
class Post
{
    private int $idPost;
    private int $idAuthor;
    private string $tittle;
    private string $text;


public function __construct( $idPost,User $idAuthor, $tittle, $text ) 
{
    $this->idPost = $idPost;
    $this->idAuthor = $idAuthor->getId();
    $this->tittle = $tittle;
    $this->text = $text;

}

public function getIdPost(): int
{
return $this->idPost;
}

public function getidAuthor(): int
{
return $this->idAuthor;
}

public function __toString()
{
return 'id статьи : '. $this->getIdPost() .
 'Автор id :'. $this->idAuthor .
  ' пишет: ' .$this->tittle .
  'текст статьи : '. $this->text;
}

/**
 * Get the value of idPost
 */


}
