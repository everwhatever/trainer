<?php

declare(strict_types=1);

namespace App\Blog\Application\Message\Command;

use App\Blog\Domain\Model\Comment;

class CommentCreationMessage
{
    public function __construct(private readonly Comment $comment, private readonly int $userId, private readonly int $postId)
    {
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }
}
