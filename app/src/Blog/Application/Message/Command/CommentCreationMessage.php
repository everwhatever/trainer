<?php

declare(strict_types=1);

namespace App\Blog\Application\Message\Command;

use App\Blog\Domain\Model\Comment;

class CommentCreationMessage
{
    private Comment $comment;

    private int $userId;

    private int $postId;

    public function __construct(Comment $comment, int $userId, int $postId)
    {
        $this->comment = $comment;
        $this->userId = $userId;
        $this->postId = $postId;
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
