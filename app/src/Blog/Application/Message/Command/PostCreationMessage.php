<?php

declare(strict_types=1);

namespace App\Blog\Application\Message\Command;

use App\Blog\Domain\Model\Post;

class PostCreationMessage
{
    public function __construct(private Post $post, private ?int $userId)
    {
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
