<?php

declare(strict_types=1);

namespace App\Blog\Domain\Service;

use App\Blog\Domain\Model\Comment;
use App\Blog\Domain\Model\Post;
use Doctrine\ORM\EntityManagerInterface;

class CommentSaver
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveComment(Comment $comment, int $userId, int $postId): void
    {
        /** @var Post $post */
        $post = $this->entityManager->getRepository(Post::class)->findOneBy(['id' => $postId]);
        $comment->setAuthorId($userId);
        $comment->setPost($post);
        $post->addComment($comment);

        $this->entityManager->persist($comment);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}
