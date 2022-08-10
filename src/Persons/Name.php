<?php 
namespace Ltreu\MyHabr\Persons;

class Name
{
    private string $firstName;
    private string $lastName;

    public function __construct(
        string $firstName,
        string $lastName
    ) {
        $this->lastName = $lastName;
        $this->firstName = $firstName;
    }
    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return string
     */
    public function first(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function last(): string
    {
        return $this->lastName;
    }


}
