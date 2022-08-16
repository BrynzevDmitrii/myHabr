<?php
namespace Ltreu\MyHabr\Blog\Commands;

use Ltreu\MyHabr\Blog\Post;
use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Exceptions\PostNotFoundException;
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
        throw new CommandException("Title already exists: $title");
    }
        $this->postsRepository->save(new Post(
            UUID::random(),
            $arguments->get('autor_uuid'),
            $arguments->get('title'),
            $arguments->get('text')
            ));
        
    }
        
    private function userExists(string $titlePost): bool
    {
    try {
        $this->postsRepository->getPostTitle($titlePost);
    } catch (PostNotFoundException) {
        return false;
    }
        return true;
    }



 }