<?php
namespace Ltreu\MyHabr\HTTP\Actions\Users;

use Ltreu\MyHabr\HTTP\Request;
use Ltreu\MyHabr\HTTP\ErrorResponse;
use Ltreu\MyHabr\Exceptions\HttpException;
use Ltreu\MyHabr\HTTP\Actions\ActionInterface;
use Ltreu\MyHabr\Blog\Repositories\interfaces\UsersRepositoryInterface;


class FindByUuid implements ActionInterface
{
        public function __construct(
           private UsersRepositoryInterface $usersRepository
        ) {
        }

        public function handle(Request $request): Response
        {
            try {

                $uuid = $request->query('uuid');
                } catch (HttpException $e) {
            
                return new ErrorResponse($e->getMessage());
                }

                try {
                    $user = $this->usersRepository->get($uuid);
                    } catch (UserNotFoundException $e) {
                    
                    return new ErrorResponse($e->getMessage());
                    }

                    return new SuccessfulResponse([
                        'name' => $user->name()->first() . ' ' . $user->name()->last(),
                        ]);
                    
        }

    }        