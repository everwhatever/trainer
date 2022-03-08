<?php

declare(strict_types=1);

namespace App\Blog\Application\Message\Command;

use App\Blog\Domain\Model\Post;

class PostCreationMessage
{
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getPost(): Post
    {
        return $this->post;
    }
}
