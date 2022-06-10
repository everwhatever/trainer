<?php

declare(strict_types=1);

namespace App\Blog\Application\DTO;

use App\Blog\Domain\Model\Post;

class PostDTO
{
    private function __construct(public readonly string $title, public readonly string $content,
                                 public readonly int $postId, public readonly array $comments,
                                 public readonly array $authorInfo)
    {
    }

    public static function create(Post $post, array $comments, array $authorInfo): self
    {
        return new self($post->getTitle(), $post->getContent(), $post->getId(), $comments, $authorInfo);
    }
}
