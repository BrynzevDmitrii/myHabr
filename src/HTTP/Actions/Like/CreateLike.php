<?php
namespace Ltreu\MyHabr\HTTP\Actions\Like;

use Ltreu\MyHabr\Blog\Like;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\HTTP\Request;
use Ltreu\MyHabr\HTTP\Response;
use Ltreu\MyHabr\HTTP\ErrorResponse;
use Ltreu\MyHabr\HTTP\SuccessfulResponse;
use Ltreu\MyHabr\Exceptions\HttpException;
use Ltreu\MyHabr\HTTP\Actions\ActionInterface;
use Ltreu\MyHabr\Blog\Repositories\Interfaces\LikesRepositoryInterface;
use Ltreu\MyHabr\Blog\Repositories\interfaces\PostsRepositoryInterface;
use Ltreu\MyHabr\Blog\Repositories\interfaces\UsersRepositoryInterface;

class CreateLike implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository,
        private UsersRepositoryInterface $userRepository,
        private LikesRepositoryInterface $likeRepository,

        ) {
        }

        public function handle(Request $request): Response
        {

            try {
                $postUuid = new UUID($request->jsonBodyField('post_uuid'));
                } catch (HttpException | InvalidArgumentException $e) {
                return new ErrorResponse($e->getMessage());
                }

            try {
                $userUuid = new UUID($request->jsonBodyField('user_uuid'));
                } catch (HttpException | InvalidArgumentException $e) {
                return new ErrorResponse($e->getMessage());
                }

            try {
                $post = $this->postsRepository->getPostToUuidPost($postUuid);
                } catch (UserNotFoundException $e) {
                return new ErrorResponse($e->getMessage());
                }

            try {
                $user = $this->userRepository->get($userUuid);
                } catch (UserNotFoundException $e) {
                return new ErrorResponse($e->getMessage());
                }    



                $newLikeUuid = UUID::random();

                try {
                $like = new Like(
                $newLikeUuid,
                $post, 
                $user
                );

                $this->likeRepository->save($like);
                } catch (HttpException $e) {
                return new ErrorResponse($e->getMessage());
                }

                return new SuccessfulResponse([
                    'uuid' => (string)$newLikeUuid,
                    ]);


        }
}