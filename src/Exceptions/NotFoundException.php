<?php
namespace Ltreu\MyHabr\Exceptions;


use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends \Exception implements NotFoundExceptionInterface
{

}