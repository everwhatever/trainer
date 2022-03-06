<?php

declare(strict_types=1);

namespace App\TrainingPlan\UI\Controller\AboutMe;

use App\TrainingPlan\Domain\Model\AboutMe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/about-me/display/{id}", name="about_me_display")
     */
    public function displayAction(int $id): Response
    {
        /** @var AboutMe $aboutMe */
        $aboutMe = $this->entityManager->getRepository(AboutMe::class)->findOneBy(['id' => $id]);
        $photoDir = $this->getParameter('photo_directory');

        return $this->render('training_plan/about_me/about_me_display.html.twig', [
            'title' => $aboutMe->getTitle(),
            'description' => $aboutMe->getDescription(),
            'photo_filename' => $photoDir . '/' . $aboutMe->getPhotoFilename()
        ]);
    }
}