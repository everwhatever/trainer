<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\User\Application\Message\Command\AboutMeCreationMessage;
use App\User\Domain\Service\AboutMeCreatorService;
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
        $aboutMe = $message->getAboutMe();

        $this->aboutMeCreator->create($photo, $aboutMe);
    }
}