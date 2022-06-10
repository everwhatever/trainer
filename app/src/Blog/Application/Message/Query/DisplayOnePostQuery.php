<?php

declare(strict_types=1);

namespace App\Blog\Application\Message\Query;

class DisplayOnePostQuery
{
    public function __construct(private readonly int $postId)
    {
    }

    public function getPostId(): int
    {
        return $this->postId;
    }
}
