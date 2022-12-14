<?php
namespace Ltreu\MyHabr\Blog;
use Ltreu\MyHabr\Exceptions\InvalidArgumentException;


class UUID 
{
    private string $uuidString;

    public function __construct(string $uuid)
    {
        if(!uuid_is_valid($uuid)){
            throw new InvalidArgumentException(
                "Malformed UUID: $this->uuidString"
                );
        }
        $this->uuidString = $uuid;
    }

    public static function random(): self
    {
    return new self(uuid_create(UUID_TYPE_RANDOM));
    }

    public function __toString(): string
    {
    return $this->uuidString;
    }

}