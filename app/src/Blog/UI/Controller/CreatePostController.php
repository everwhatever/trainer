<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller;

use App\Blog\Application\Message\Command\PostCreationMessage;
use App\Blog\Domain\Model\Post;
use App\Blog\Infrastructure\Form\CreatePostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class CreatePostController extends AbstractController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route(path: '/blog/create', name: 'blog_create_post')]
    public function createAction(Request $request): Response
    {
        $userId = $this->getUser()->getId();
        $form = $this->createForm(CreatePostType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $this->command($post, $userId);

            return $this->redirectToRoute('blog_display_all_posts');
        }

        return $this->render('blog/create_post.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function command(Post $post, int $userId): void
    {
        $message = new PostCreationMessage($post, $userId);
        $this->commandBus->dispatch($message);
    }
}
