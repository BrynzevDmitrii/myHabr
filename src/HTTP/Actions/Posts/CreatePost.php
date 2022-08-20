<?php
namespace Ltreu\MyHabr\HTTP\Actions\Posts;

use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\HTTP\Request;
use Ltreu\MyHabr\HTTP\Response;
use Ltreu\MyHabr\HTTP\ErrorResponse;
use Ltreu\MyHabr\HTTP\SuccessfulResponse;
use Ltreu\MyHabr\Exceptions\HttpException;
use Ltreu\MyHabr\HTTP\Actions\ActionInterface;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\PostsRepositoryInterface;
use Ltreu\MyHabr\Blog\Repositories\interfaces\UsersRepositoryInterface;

class CreatePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository,
        private UsersRepositoryInterface $usersRepository,
        ) {
        }
        public function handle(Request $request): Response
            {
        
            try {
            $authorUuid = new UUID($request->jsonBodyField('author_uuid'));
            } catch (HttpException | InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage());
            }
            
            try {
            $user = $this->usersRepository->get($authorUuid);
            } catch (UserNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
            }
            
            $newPostUuid = UUID::random();
            try {
            $comment = new Post(
            $newPostUuid,
            $user,
            $request->jsonBodyField('title'),
            $request->jsonBodyField('text'),
            );
            } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
            }
            
            $this->postsRepository->save($comment);
           
            return new SuccessfulResponse([
            'uuid' => (string)$newPostUuid,
            ]);
            }
                   
}