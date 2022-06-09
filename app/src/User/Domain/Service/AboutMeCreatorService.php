<?php

declare(strict_types=1);

namespace App\User\Domain\Service;

use App\Shared\Application\Service\PhotoFilenameService;
use App\User\Domain\Model\AboutMe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;

class AboutMeCreatorService
{
    public function __construct(private EntityManagerInterface $entityManager, private PhotoFilenameService $filenameService)
    {
    }

    public function create(File $photo, AboutMe $aboutMe): void
    {
        $newFilename = $this->filenameService->preparePhotoFilename($photo);

        $aboutMe->setPhotoFilename($newFilename);

        $this->entityManager->persist($aboutMe);
        $this->entityManager->flush();
    }
}
