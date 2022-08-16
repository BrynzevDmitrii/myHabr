<?php
namespace Ltreu\MyHabr\tests\Comment;


use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Blog\Comment;
use PHPUnit\Framework\TestCase;
use Ltreu\MyHabr\Blog\Commands\Arguments;
use Ltreu\MyHabr\Exceptions\ArgumentsException;
use Ltreu\MyHabr\Blog\Commands\CreateCommetsCommand;
use Ltreu\MyHabr\Exceptions\CommentNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\CommentsRepositoryInterface;


class CreateCommentCommandTest extends TestCase
{
    public function testItThrowsAnExceptionWhenCommentAlreadyExists():void
    {
        $commentRepository = new class implements CommentsRepositoryInterface
        {
            public function save(Comment $textComment):void
            {

            }

            public function get(UUID $id): Comment
            {
            throw new CommentNotFoundException("Not found");
            }


            public function getText(string $commentText): bool
            {
            throw new CommentNotFoundException("Not found");
            }
        };

        $command = new CreateCommetsCommand($commentRepository);

        $this->expectException(ArgumentsException::class);

        
        $this->expectExceptionMessage('No such argument: post_uuid');

        $command->handle(new Arguments(['text'=>'ho-ho-ho ddd']));
    }
}