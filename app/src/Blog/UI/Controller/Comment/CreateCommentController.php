<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller\Comment;

use App\Blog\Application\Message\Command\CommentCreationMessage;
use App\Blog\Domain\Model\Comment;
use App\Blog\Infrastructure\Form\CreateCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class CreateCommentController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    #[Route(path: '/blog/{postId}/comment/create', name: 'blog_comment_create')]
    public function createAction(Request $request, int $postId): Response
    {
        $userId = $this->getUser()->getId();
        $form = $this->createForm(CreateCommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();

            $this->command($comment, $userId, $postId);

            return $this->redirectToRoute('blog_display_one_post', ['id' => $postId]);
        }

        return $this->render('blog/create_comment.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function command(Comment $comment, int $userId, int $postId): void
    {
        $message = new CommentCreationMessage($comment, $userId, $postId);
        $this->commandBus->dispatch($message);
    }
}
