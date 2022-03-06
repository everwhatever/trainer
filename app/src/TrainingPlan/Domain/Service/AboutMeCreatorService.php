<?php

declare(strict_types=1);

namespace App\TrainingPlan\Domain\Service;

use App\TrainingPlan\Domain\Model\AboutMe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;

class AboutMeCreatorService
{
    private EntityManagerInterface $entityManager;

    private SluggerInterface $slugger;

    private string $photoDirectory;

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger, string $photoDirectory)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
        $this->photoDirectory = $photoDirectory;
    }

    public function create(File $photo, AboutMe $aboutMe): void
    {
        $newFilename = $this->preparePhotoFilename($photo);

        $aboutMe->setPhotoFilename($newFilename);

        $this->entityManager->persist($aboutMe);
        $this->entityManager->flush();
    }

    private function preparePhotoFilename(File $photo): string
    {
        $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();

        try {
            $photo->move(
                $this->photoDirectory,
                $newFilename
            );
        } catch (FileException $e) {
            throw new FileException($e->getMessage());
        }

        return $newFilename;
    }
}
