<?php

declare(strict_types=1);

namespace App\User\UI\Controller\AboutMe;

use App\User\Domain\Model\AboutMe;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly string $shortPhotoDir)
    {
    }

    #[Route(path: '/about-me/display', name: 'about_me_display_one')]
    public function displayOneAction(): Response
    {
        /** @var AboutMe $aboutMe */
        $aboutMe = $this->entityManager->getRepository(AboutMe::class)->findOneBy(['isActive' => true]);

        return $this->render('user/about_me/about_me_display_one.html.twig', [
            'title' => $aboutMe->getTitle(),
            'description' => $aboutMe->getDescription(),
            'photo_dir' => $this->shortPhotoDir.$aboutMe->getPhotoFilename(),
        ]);
    }

    #[Route(path: '/about-me/display/all', name: 'about_me_display_all')]
    #[IsGranted('ROLE_ADMIN')]
    public function displayAllAction(): Response
    {
        $aboutMeList = $this->entityManager->getRepository(AboutMe::class)->findAll();

        return $this->render('user/about_me/about_me_display_all.html.twig', [
            'aboutMeList' => $aboutMeList,
        ]);
    }
}
