<?php
namespace Ltreu\MyHabr\HTTP\Actions\Users;

use Ltreu\MyHabr\HTTP\Request;
use Ltreu\MyHabr\HTTP\Response;
use Ltreu\MyHabr\HTTP\ErrorResponse;
use Ltreu\MyHabr\HTTP\SuccessfulResponse;
use Ltreu\MyHabr\HTTP\Actions\ActionInterface;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\UsersRepositoryInterface;

class FindByUsername implements ActionInterface
{
        public function __construct(
           private UsersRepositoryInterface $usersRepository
        ) {
        }

        public function handle(Request $request): Response
        {
            try {

            $username = $request->query('username');
            } catch (HttpException) {
        
            return new ErrorResponse('findByUsername');
            }
            try {
            $user = $this->usersRepository->getByUsername($username);
            } catch (UserNotFoundException $e) {
            
            return new ErrorResponse($e->getMessage());
            }
            
            return new SuccessfulResponse([
            'username' => $user->username(),
            'name' => $user->name()->first() . ' ' . $user->name()->last(),
            ]);
        }

}