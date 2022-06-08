<?php

namespace App\User\Application\Handler\Command;

use App\User\Application\Message\Command\UserCreationMessage;
use App\User\Domain\Model\User;
use App\User\Domain\Service\UserCreatorService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserCreationHandler implements MessageHandlerInterface
{
    private UserCreatorService $userCreator;

    public function __construct(UserCreatorService $userCreator)
    {
        $this->userCreator = $userCreator;
    }

    public function __invoke(UserCreationMessage $message): User
    {
        return $this->userCreator->createUser($message->getEmail(), $message->getPlainPassword(), $message->getRole());
    }
}
