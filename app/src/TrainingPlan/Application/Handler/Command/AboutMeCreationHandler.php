<?php

declare(strict_types=1);

namespace App\TrainingPlan\Application\Handler\Command;

use App\TrainingPlan\Application\Message\Command\AboutMeCreationMessage;
use App\TrainingPlan\Domain\Service\AboutMeCreatorService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AboutMeCreationHandler implements MessageHandlerInterface
{
    private AboutMeCreatorService $aboutMeCreator;

    public function __construct(AboutMeCreatorService $aboutMeCreator)
    {
        $this->aboutMeCreator = $aboutMeCreator;
    }

    public function __invoke(AboutMeCreationMessage $message): void
    {
        $photo = $message->getPhoto();
        $title = $message->getTitle();
        $description = $message->getDescription();

        $this->aboutMeCreator->create($photo, $title, $description);
    }
}