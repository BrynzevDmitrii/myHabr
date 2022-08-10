<?php 

namespace Ltreu\MyHabr\Blog;

use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Persons\User;

class Post
{
    private UUID $id;
    private UUID $idAuthor;
    private string $title;
    private string $text;


public function __construct( UUID $id,User $idAuthor, $title, $text ) 
{
    $this->id = $id;
    $this->idAuthor = $idAuthor->uuid();
    $this->title = $title;
    $this->text = $text;

}

public function uuid(): UUID
{
return $this->id;
}

public function autor_uuid(): UUID
{
    return $this->idAuthor;
}

public function __toString()
{
return 'id статьи : '. $this->getIdPost() .
 'Автор id :'. $this->idAuthor .
  ' пишет: ' .$this->title .
  'текст статьи : '. $this->text;
}

/**
 * Get the value of idPost
 */



    /**
     * Get the value of tittle
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the value of text
     */
    public function getText(): string
    {
        return $this->text;
    }
}
