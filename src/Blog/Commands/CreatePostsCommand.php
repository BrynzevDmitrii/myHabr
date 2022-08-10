<?php
namespace Ltreu\MyHabr\Blog\Commands;

use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\Repositories\interfaces\PostsRepositoryInterface;





class CreatePostsCommand 
 {
    private PostsRepositoryInterface $postsRepository;

    public function __construct(PostsRepositoryInterface $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    public function handle(Arguments $arguments): void
    {
        $title = $arguments->get('title');
    if ($this->userExists($title)) {
        throw new CommandException("User already exists: $title");
    }
        $this->usersRepository->save(new Post(
            UUID::random(),
            $arguments->get('autor_uuid'),
            $arguments->get('title'),
            $arguments->get('text')
            ));
        
    }
        
    private function userExists(string $titlePost): Post
    {
    try {
        $this->postsRepository->getPostTitle($titlePost);
    } catch (UserNotFoundException) {
        return false;
    }
        return true;
    }



 }