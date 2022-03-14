<?php

declare(strict_types=1);

namespace App\User\Domain\Service;

use App\User\Application\Service\PhotoFilenameService;
use App\User\Domain\Model\AboutMe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;

class AboutMeCreatorService
{
    private EntityManagerInterface $entityManager;

    private PhotoFilenameService $filenameService;

    public function __construct(EntityManagerInterface $entityManager, PhotoFilenameService $filenameService)
    {
        $this->entityManager = $entityManager;
        $this->filenameService = $filenameService;
    }

    public function create(File $photo, AboutMe $aboutMe): void
    {
        $newFilename = $this->filenameService->preparePhotoFilename($photo);

        $aboutMe->setPhotoFilename($newFilename);

        $this->entityManager->persist($aboutMe);
        $this->entityManager->flush();
    }
}
