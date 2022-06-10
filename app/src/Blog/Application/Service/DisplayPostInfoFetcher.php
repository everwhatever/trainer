<?php

declare(strict_types=1);

namespace App\Blog\Application\Service;

use App\Blog\Application\DTO\PostDTO;
use App\Blog\Domain\Model\Comment;
use App\Blog\Domain\Model\Post;
use Doctrine\ORM\EntityManagerInterface;

class DisplayPostInfoFetcher
{
    public function __construct(private readonly UserInfoApiGetter $apiGetter, private readonly EntityManagerInterface $entityManager)
    {
    }

    public function fetch(int $postId): PostDTO
    {
        /** @var Post $post */
        $post = $this->entityManager->getRepository(Post::class)->findOneBy(['id' => $postId]);
        $authorInfo = $this->apiGetter->getUserInfoById([$post->getAuthorId()], 'email, last_name, first_name');
        $commentsObjects = $post->getComments()->toArray();
        $comments = [];

        /** @var Comment $comment */
        foreach ($commentsObjects as $comment) {
            $comments[] = ['id' => $comment->getId(), 'content' => $comment->getContent(), 'author' => $this->apiGetter->getUserInfoById([$comment->getAuthorId()], 'email')['email']];
        }

        // TODO: n+1 problem here with comments

        return PostDTO::create($post, $comments, $authorInfo);
    }
}
