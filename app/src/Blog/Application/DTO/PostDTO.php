<?php

declare(strict_types=1);

namespace App\Blog\Application\DTO;

use App\Blog\Domain\Model\Post;

class PostDTO
{
    private function __construct(private readonly string $title, private readonly string $content, private readonly int $postId, private readonly array $comments, private readonly array $authorInfo)
    {
    }

    public static function create(Post $post, array $comments, array $authorInfo): self
    {
        return new self($post->getTitle(), $post->getContent(), $post->getId(), $comments, $authorInfo);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function getAuthorInfo(): array
    {
        return $this->authorInfo;
    }
}
