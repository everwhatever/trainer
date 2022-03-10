<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller;

use App\Blog\Application\Message\Command\PostCreationMessage;
use App\Blog\Domain\Model\Post;
use App\Blog\Infrastructure\Form\CreatePostType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class EditPostController extends AbstractController
{
    private MessageBusInterface $commandBus;

    private EntityManagerInterface $entityManager;

    public function __construct(MessageBusInterface $commandBus, EntityManagerInterface $entityManager)
    {
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/blog/edit/{id}", name="blog_edit_post")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editAction(Request $request, int $id): Response
    {
        $post = $this->entityManager->getRepository(Post::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(CreatePostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $this->command($post);

            return $this->redirectToRoute('blog_display_one_post', ['id' => $post->getId()]);
        }

        return $this->render('blog/edit_post.html.twig', [
            'form' => $form->createView(),
            'postId' => $post->getId()
        ]);
    }

    private function command(Post $post): void
    {
        $message = new PostCreationMessage($post);
        $this->commandBus->dispatch($message);
    }
}