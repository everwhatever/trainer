<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller;

use App\Blog\Domain\Model\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/display")
 */
class DisplayController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
        /** @var Post $post */
        $post = $this->entityManager->getRepository(Post::class)->findOneBy(['id' => $id]);

        return $this->render('blog/display_one_post.html.twig', [
            'title' => $post->getTitle(),
            'content' => $post->getContent()
        ]);
    }
}