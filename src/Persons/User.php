<?php

namespace Ltreu\MyHabr\Persons;

use Ltreu\MyHabr\Blog\UUID;

class User
{
    private UUID $idAuthor;
    private string $username;
    private Name $name;

    public function __construct( UUID $id, string $username , Name $name )
 {
    $this->idAuthor = $id;
    $this->name= $name;
    $this->username = $username;
}

public function __toString()
{
    $firstName = $this->name()->first();
    $lastName = $this->name()->last();
}

/**
 * Get the value of id
 */

public function uuid(): UUID
{
    return $this->idAuthor;
}

public function username(): string
{
    return $this->username;
}

public function name(): Name
    {
        return $this->name;
    }
}
