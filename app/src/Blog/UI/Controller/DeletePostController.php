<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller;

use App\Blog\Domain\Model\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeletePostController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route(path: '/blog/delete/{id}', name: 'blog_delete_post')]
    public function deleteAction(int $id): Response
    {
        $post = $this->entityManager->getRepository(Post::class)->findOneBy(['id' => $id]);
        $this->entityManager->remove($post);
        $this->entityManager->flush();

        return $this->redirectToRoute('blog_display_all_posts');
    }
}
