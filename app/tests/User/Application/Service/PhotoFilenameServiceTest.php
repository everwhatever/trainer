<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\UnicodeString;

function uniqid(): string
{
    return '23';
}

class PhotoFilenameServiceTest extends TestCase
{
    private PhotoFilenameService $filenameService;

    protected function setUp(): void
    {
        $sluggerMock = $this->createMock(SluggerInterface::class);
        $sluggerMock->method('slug')->willReturn(new UnicodeString('zdj'));

        $this->filenameService = new PhotoFilenameService($sluggerMock, '/public/uploads/photo');
    }

    public function testPreparePhotoFilename()
    {
        $photo = $this->createMock(UploadedFile::class);
        $photo->method('getClientOriginalName')->willReturn('zdj');
        $photo->method('guessExtension')->willReturn('jpeg');

        $filename = $this->filenameService->preparePhotoFilename($photo);
        self::assertEquals('zdj-23.jpeg', $filename);
    }
}
