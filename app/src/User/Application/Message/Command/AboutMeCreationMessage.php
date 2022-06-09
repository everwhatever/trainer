<?php

declare(strict_types=1);

namespace App\User\Application\Message\Command;

use App\User\Domain\Model\AboutMe;
use Symfony\Component\HttpFoundation\File\File;

class AboutMeCreationMessage
{
    public function __construct(private File $photo, private AboutMe $aboutMe)
    {
    }

    public function getPhoto(): File
    {
        return $this->photo;
    }

    public function getAboutMe(): AboutMe
    {
        return $this->aboutMe;
    }
}
