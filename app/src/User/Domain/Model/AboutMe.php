<?php

declare(strict_types=1);

namespace App\User\Domain\Model;

use App\User\Infrastructure\Repository\AboutMeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AboutMeRepository::class)
 * @ORM\Table(name="`about_me`")
 */
class AboutMe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $photoFilename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private bool $isActive;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPhotoFilename(): string
    {
        return $this->photoFilename;
    }

    public function setPhotoFilename(string $photoFilename): void
    {
        $this->photoFilename = $photoFilename;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }
}
