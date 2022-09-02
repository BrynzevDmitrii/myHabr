<?php
namespace Ltreu\MyHabr\HTTP\Auth;

interface IdentificationInterface
{
    public function user(Request $request): User;
} 
