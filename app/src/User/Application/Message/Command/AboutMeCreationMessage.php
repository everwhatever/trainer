<?php

declare(strict_types=1);

namespace App\User\Application\Message\Command;

use App\User\Domain\Model\AboutMe;
use Symfony\Component\HttpFoundation\File\File;

class AboutMeCreationMessage
{
    public function __construct(public readonly File $photo, public readonly AboutMe $aboutMe)
    {
    }
}
