<?php
namespace Ltreu\MyHabr\tests\PostTest;

use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use PHPUnit\Framework\TestCase;
use Ltreu\MyHabr\Blog\Commands\Arguments;
use Ltreu\MyHabr\Exceptions\ArgumentsException;
use Ltreu\MyHabr\Blog\Commands\CreatePostsCommand;
use Ltreu\MyHabr\Exceptions\PostNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\PostsRepositoryInterface;

class CreatePostCommandTest extends TestCase {
    
    public function testItThrowsAnExceptionWhenTitleAlreadyExists():void
    {
        $postsRepository = new class implements PostsRepositoryInterface
        {
            public function save(Post $title):void
            {

            }

            public function get(UUID $autor_uuid): Post
            {
            throw new PostNotFoundException("Not found");
            }


            public function getPostTitle(string $titlePost): Post
            {
            throw new PostNotFoundException("Not found");
            }
        };

        $command = new CreatePostsCommand($postsRepository);

        $this->expectException(ArgumentsException::class);

        $this->expectExceptionMessage('No such argument: autor_uuid');

        $command->handle(new Arguments(['title' => 'HTML5']));
    }
    
}