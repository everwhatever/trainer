<?php

declare(strict_types=1);

namespace App\Blog\Domain\Service;

use App\Blog\Domain\Model\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostSaver
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function savePost(Post $post, int $userId): void
    {
        $post->setAuthorId($userId);

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}