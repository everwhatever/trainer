<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\User\Application\Message\Command\AboutMeCreationMessage;
use App\User\Domain\Service\AboutMeCreatorService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AboutMeCreationHandler implements MessageHandlerInterface
{
    public function __construct(private readonly AboutMeCreatorService $aboutMeCreator)
    {
    }

    public function __invoke(AboutMeCreationMessage $message): void
    {
        $photo = $message->photo;
        $aboutMe = $message->aboutMe;

        $this->aboutMeCreator->create($photo, $aboutMe);
    }
}
