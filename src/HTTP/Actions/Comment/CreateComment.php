<?php
namespace Ltreu\MyHabr\HTTP\Actions\Comment;

use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Blog\Comment;
use Ltreu\MyHabr\HTTP\Request;
use Ltreu\MyHabr\HTTP\Response;
use Ltreu\MyHabr\HTTP\ErrorResponse;
use Ltreu\MyHabr\HTTP\SuccessfulResponse;
use Ltreu\MyHabr\Exceptions\HttpException;
use Ltreu\MyHabr\HTTP\Actions\ActionInterface;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\CommentRepository;
use Ltreu\MyHabr\Exceptions\InvalidArgumentException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\PostsRepositoryInterface;
use Ltreu\MyHabr\Blog\Repositories\interfaces\UsersRepositoryInterface;
use Ltreu\MyHabr\Blog\Repositories\interfaces\CommentsRepositoryInterface;


class CreateComment implements ActionInterface
{

    public function __construct(
        private PostsRepositoryInterface $postsRepository,
        private CommentsRepositoryInterface $CommentRepository,

        ) {
        }

        public function handle(Request $request): Response
        {

            try {
                $authorUuid = new UUID($request->jsonBodyField('autor_uuid'));
                } catch (HttpException | InvalidArgumentException $e) {
                return new ErrorResponse($e->getMessage());
                 }

                 
            try {
                $postUuid = new UUID($request->jsonBodyField('post_uuid'));
                } catch (HttpException | InvalidArgumentException $e) {
                return new ErrorResponse($e->getMessage());
                }
                


                try {
                $post = $this->postsRepository->get($authorUuid);
                } catch (UserNotFoundException $e) {
                return new ErrorResponse($e->getMessage());
                }

                // try {
                //     $post = $this->postsRepository->getPostToUuidPost($postUuid);
                //     } catch (UserNotFoundException $e) {
                //     return new ErrorResponse($e->getMessage());
                //     }
                
                $newCommentUuid = UUID::random();

                try {
                $comment = new Comment(
                $newCommentUuid,
                $post,
                $post,
                $request->jsonBodyField('text'),
                );

                $this->CommentRepository->save($comment);
                } catch (HttpException $e) {
                return new ErrorResponse($e->getMessage());
                }
                
               
               
                return new SuccessfulResponse([
                'uuid' => (string)$newCommentUuid,
                ]);
                
        }
    
}