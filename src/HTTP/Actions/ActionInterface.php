<?php
namespace Ltreu\MyHabr\HTTP\Actions;

use Ltreu\MyHabr\HTTP\Request;
use Ltreu\MyHabr\HTTP\Response;

interface ActionInterface
{
public function handle(Request $request): Response;
}
