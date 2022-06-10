<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;

class PhotoFilenameService
{
    public function __construct(private readonly SluggerInterface $slugger, private readonly string $photoDirectory)
    {
    }

    public function preparePhotoFilename(File $photo): string
    {
        $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

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
