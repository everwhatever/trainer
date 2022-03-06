<?php

declare(strict_types=1);

namespace App\TrainingPlan\Application\Message\Command;

use App\TrainingPlan\Domain\Model\AboutMe;
use Symfony\Component\HttpFoundation\File\File;

class AboutMeCreationMessage
{
    private File $photo;

    private AboutMe $aboutMe;

    public function __construct(File $photo, AboutMe $aboutMe)
    {
        $this->photo = $photo;
        $this->aboutMe = $aboutMe;
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