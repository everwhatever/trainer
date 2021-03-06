<?php

declare(strict_types=1);

namespace App\Blog\Application\Handler\Command;

use App\Blog\Application\Message\Command\PostCreationMessage;
use App\Blog\Domain\Service\PostSaver;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PostCreationHandler implements MessageHandlerInterface
{
    public function __construct(private readonly PostSaver $postSaver)
    {
    }

    public function __invoke(PostCreationMessage $message): void
    {
        $this->postSaver->savePost($message->post, $message->userId);
    }
}
