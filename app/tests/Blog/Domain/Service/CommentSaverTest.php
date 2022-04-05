<?php

declare(strict_types=1);

namespace App\Tests\Blog\Domain\Service;

use App\Blog\Domain\Model\Comment;
use App\Blog\Domain\Model\Post;
use App\Blog\Domain\Service\CommentSaver;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommentSaverTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
        $this->truncateEntities();
    }

    public function testSaveComment()
    {
        $em = $this->getEntityManager();
        $post = new Post();
        $post->setContent("d");
        $post->setTitle("d");
        $post->setAuthorId(2);
        $em->persist($post);
        $em->flush();
        $container = static::getContainer();
        $comment = new Comment();
        $comment->setContent("TEST");
        $commentSaver = $container->get(CommentSaver::class);
        $commentSaver->saveComment($comment, 2, $post->getId());
        $commentRepo = $em->getRepository(Comment::class);

        $count = (int)$commentRepo
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $this->assertSame(1, $count);

        $userId = $commentRepo->createQueryBuilder('s')
            ->select('s.authorId')
            ->getQuery()
            ->getResult()[0]['authorId'];
        $this->assertSame(2, $userId);
    }

    private function truncateEntities(): void
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    private function getEntityManager(): EntityManagerInterface
    {
        $container = static::getContainer();

        return $container->get(EntityManagerInterface::class);
    }
}
