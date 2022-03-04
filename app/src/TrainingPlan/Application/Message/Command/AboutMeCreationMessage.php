<?php

declare(strict_types=1);

namespace App\TrainingPlan\Application\Message\Command;

use Symfony\Component\HttpFoundation\File\File;

class AboutMeCreationMessage
{
    private File $photo;

    private string $title;

    private string $description;

    public function __construct(File $photo, string $title, string $description)
    {
        $this->photo = $photo;
        $this->title = $title;
        $this->description = $description;
    }

    public function getPhoto(): File
    {
        return $this->photo;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}