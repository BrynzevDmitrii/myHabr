<?php
namespace Ltreu\MyHabr\HTTP;

use Ltreu\MyHabr\HTTP\Response;

class ErrorResponse extends Response
{
    protected const SUCCESS = false;
    private string $reason = 'Something goes wrong';
    public function __construct(string $reason)
    {
        $this->reason = $reason ;
    
    }

    protected function payload(): array
    {
    return ['reason' => $this->reason];
    }

}