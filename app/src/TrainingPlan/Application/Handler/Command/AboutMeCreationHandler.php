<?php

declare(strict_types=1);

namespace App\TrainingPlan\Application\Handler\Command;

use App\TrainingPlan\Application\Message\Command\AboutMeCreationMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AboutMeCreationHandler implements MessageHandlerInterface
{
//    public function __construct()
//    {
//    }

    public function __invoke(AboutMeCreationMessage $message): void
    {
        $photo = $message->getPhoto();
        $title = $message->getTitle();
        $description = $message->getDescription();
    }
}