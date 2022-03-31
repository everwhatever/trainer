<?php

declare(strict_types=1);

namespace App\Blog\Application\Message\Command;

use App\Blog\Domain\Model\Post;

class PostCreationMessage
{
    private Post $post;

    private ?int $userId;

    public function __construct(Post $post, int $userId)
    {
        $this->post = $post;
        $this->userId = $userId;
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
