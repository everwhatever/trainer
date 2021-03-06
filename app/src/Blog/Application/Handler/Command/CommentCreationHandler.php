<?php

declare(strict_types=1);

namespace App\Blog\Application\Handler\Command;

use App\Blog\Application\Message\Command\CommentCreationMessage;
use App\Blog\Domain\Service\CommentSaver;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CommentCreationHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CommentSaver $commentSaver)
    {
    }

    public function __invoke(CommentCreationMessage $message): void
    {
        $this->commentSaver->saveComment($message->comment,
            $message->userId, $message->postId);
    }
}
