<?php
namespace Ltreu\MyHabr\HTTP;

use Ltreu\MyHabr\HTTP\Response;


class SuccessfulResponse extends Response 
{
    protected const SUCCESS = true;

    private array $data = [];

    public function __construct(array $data){
        $this->data = $data;
    }

    protected function payload(): array
    {
    return ['data' => $this->data];
    }


}