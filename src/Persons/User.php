<?php

namespace Ltreu\MyHabr\Persons;

class User
{
public function __construct(private int $id, private string $firstName)
 {
    $this->idAuthor = $id;
    $this->firstName = $firstName;

}

public function __toString()
{
return $this->firstName ;
}

/**
 * Get the value of id
 */
public function getId(): int
{
return $this->id;
}

/**
 * Set the value of id
 */
public function setId(int $id): self
{
$this->id = $id;

return $this;
}
}
