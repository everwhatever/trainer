<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller;

use App\Blog\Application\DTO\PostDTO;
use App\Blog\Application\Message\Query\DisplayOnePostQuery;
use App\Blog\Domain\Model\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/display")
 */
class DisplayController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private MessageBusInterface $queryBus;

    public function __construct(EntityManagerInterface $entityManager, MessageBusInterface $queryBus)
    {
        $this->entityManager = $entityManager;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("/all", name="blog_diplay_all_posts")
     */
    public function displayAllPostsAction(): Response
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();

        return $this->render('blog/display_all_posts.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/one/{id}", name="blog_display_one_post")
     */
    public function displayOnePostAction(int $id): Response
    {
        $postDTO = $this->query($id);
        $authorInfo = $postDTO->getAuthorInfo();

        return $this->render('blog/display_one_post.html.twig', [
            'title' => $postDTO->getTitle(),
            'content' => $postDTO->getContent(),
            'author_first_name' => $authorInfo['first_name'] ?? '',
            'author_email' => $authorInfo['email'] ?? '',
            'author_last_name' => $authorInfo['last_name'] ?? '',
            'comments' => $postDTO->getComments(),
            'post_id' => $postDTO->getPostId()
        ]);
    }

    private function query(int $id): PostDTO
    {
        $message = new DisplayOnePostQuery($id);
        $envelope = $this->queryBus->dispatch($message);
        /** @var HandledStamp $handleStamp */
        $handleStamp = $envelope->last(HandledStamp::class);
        return $handleStamp->getResult();
    }
}
