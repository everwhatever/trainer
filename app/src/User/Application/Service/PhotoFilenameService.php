<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;

class PhotoFilenameService
{
    private SluggerInterface $slugger;

    private string $photoDirectory;

    public function __construct(SluggerInterface $slugger, string $photoDirectory)
    {
        $this->slugger = $slugger;
        $this->photoDirectory = $photoDirectory;
    }

    public function preparePhotoFilename(File $photo): string
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