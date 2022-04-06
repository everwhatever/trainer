<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller\Comment;

use App\Blog\Domain\Model\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteCommentController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/blog/comment/delete/{id}", name="blog_comment_delete")
     * @throws Exception
     */
    public function deleteAction(int $id): Response
    {
        //TODO: sprawdzić czemu są złe idki przy zapisaniu

        $comment = $this->entityManager->getRepository(Comment::class)->findOneBy(['id' => $id]);

        if ($this->getUser()->getId() !== $comment->getAuthorId() && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw new Exception('No access!');
        }

        $this->entityManager->remove($comment);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_homepage');
    }
}