<?php 
namespace Ltreu\MyHabr\Blog\Commands;

use Ltreu\MyHabr\Blog\UUID;
use Ltreu\MyHabr\Blog\Comment;
use Ltreu\MyHabr\Blog\Commands\Arguments;
use Ltreu\MyHabr\Exceptions\UserNotFoundException;
use Ltreu\MyHabr\Blog\Repositories\interfaces\CommentsRepositoryInterface;

class CreateCommetsCommand
{
    private CommentsRepositoryInterface $commentRepository;

    public function __construct(CommentsRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(Arguments $arguments): void
    {
        $commentText = $arguments->get('text');
    if ($this->userExists($commentText)) {
        throw new CommandException("User already exists: $commentText");
    }
        $this->commentRepository->save(new Comment(
            UUID::random(),
            $arguments->get('post_uuid'),
            $arguments->get('autor_uuid'),
            $arguments->get('text')
            ));
        
    }

    private function commentExists(string $commentText): bool
    {
    try {
        $this->commentRepository->getText($commentText);
    } catch (UserNotFoundException) {
        return false;
    }
        return true;
    }
}