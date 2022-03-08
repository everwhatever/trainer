<?php

declare(strict_types=1);

namespace App\TrainingPlan\UI\Controller\AboutMe;

use App\TrainingPlan\Domain\Model\AboutMe;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private string $shortPhotoDir;

    public function __construct(EntityManagerInterface $entityManager, string $shortPhotoDir)
    {
        $this->entityManager = $entityManager;
        $this->shortPhotoDir = $shortPhotoDir;
    }

    /**
     * @Route("/about-me/display", name="about_me_display_one")
     */
    public function displayOneAction(): Response
    {
        /** @var AboutMe $aboutMe */
        $aboutMe = $this->entityManager->getRepository(AboutMe::class)->findOneBy(['isActive' => true]);

        return $this->render('training_plan/about_me/about_me_display_one.html.twig', [
            'title' => $aboutMe->getTitle(),
            'description' => $aboutMe->getDescription(),
            'photo_dir' => $this->shortPhotoDir . $aboutMe->getPhotoFilename()
        ]);
    }

    /**
     * @Route("/about-me/display/all", name="about_me_display_all")
     * @IsGranted("ROLE_ADMIN")
     */
    public function displayAllAction(): Response
    {
        $aboutMeList = $this->entityManager->getRepository(AboutMe::class)->findAll();

        return $this->render('training_plan/about_me/about_me_display_all.html.twig', [
            'aboutMeList' => $aboutMeList,
        ]);
    }
}