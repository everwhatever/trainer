<?php

declare(strict_types=1);

namespace App\Blog\Application\Message\Command;

use App\Blog\Domain\Model\Comment;

class CommentCreationMessage
{
    public function __construct(public readonly Comment $comment, public readonly int $userId, public readonly int $postId)
    {
    }
}
