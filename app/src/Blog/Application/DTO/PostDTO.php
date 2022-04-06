<?php

declare(strict_types=1);

namespace App\Blog\Application\DTO;

use App\Blog\Domain\Model\Post;

class PostDTO
{
    private string $title;

    private string $content;

    private int $postId;

    private array $comments;

    private array $authorInfo;

    private function __construct(string $title, string $content, int $postId, array $comments, array $authorInfo)
    {
        $this->title = $title;
        $this->content = $content;
        $this->postId = $postId;
        $this->comments = $comments;
        $this->authorInfo = $authorInfo;
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
