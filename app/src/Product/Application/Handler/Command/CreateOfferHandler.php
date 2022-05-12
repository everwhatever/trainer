<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Command;

use App\Product\Application\Message\Command\CreateOfferMessage;
use App\Shared\Application\Service\PhotoFilenameService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateOfferHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    private PhotoFilenameService $filenameService;

    public function __construct(EntityManagerInterface $entityManager, PhotoFilenameService $filenameService)
    {
        $this->entityManager = $entityManager;
        $this->filenameService = $filenameService;
    }

    public function __invoke(CreateOfferMessage $message): void
    {
        $photo = $message->getPhoto();
        $offer = $message->getOffer();

        $newFilename = $this->filenameService->preparePhotoFilename($photo);

        $offer->setPhotoFilename($newFilename);

        $this->entityManager->persist($offer);
        $this->entityManager->flush();
    }
}
