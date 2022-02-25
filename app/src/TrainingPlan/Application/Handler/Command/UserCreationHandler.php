<?php

namespace App\TrainingPlan\Application\Handler\Command;

use App\TrainingPlan\Application\Message\Command\UserCreationMessage;
use App\TrainingPlan\Domain\Model\User;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserCreationHandler implements MessageHandlerInterface
{
    public function __invoke(UserCreationMessage $message): User
    {

    }
}