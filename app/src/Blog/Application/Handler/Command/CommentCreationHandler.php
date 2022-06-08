<?php

declare(strict_types=1);

namespace App\Blog\Application\Handler\Command;

use App\Blog\Application\Message\Command\CommentCreationMessage;
use App\Blog\Domain\Service\CommentSaver;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CommentCreationHandler implements MessageHandlerInterface
{
    private CommentSaver $commentSaver;

    public function __construct(CommentSaver $commentSaver)
    {
        $this->commentSaver = $commentSaver;
    }

    public function __invoke(CommentCreationMessage $message): void
    {
        $this->commentSaver->saveComment($message->getComment(),
            $message->getUserId(), $message->getPostId());
    }
}
