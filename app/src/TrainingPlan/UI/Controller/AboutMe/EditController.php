<?php

declare(strict_types=1);

namespace App\TrainingPlan\UI\Controller\AboutMe;

use App\TrainingPlan\Application\Message\Command\AboutMeCreationMessage;
use App\TrainingPlan\Domain\Model\AboutMe;
use App\TrainingPlan\Infrastructure\Form\AboutMeType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    private MessageBusInterface $commandBus;

    private EntityManagerInterface $entityManager;

    public function __construct(MessageBusInterface $commandBus, EntityManagerInterface $entityManager)
    {
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/about-me/edit/{id}", name="aboute_me_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editAction(Request $request, int $id): Response
    {
        $aboutMe = $this->entityManager->getRepository(AboutMe::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(AboutMeType::class, $aboutMe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aboutMe = $form->getData();
            $this->command($form->get('photo')->getData(), $aboutMe);

            return $this->redirectToRoute('about_me_display_one');
        }

        return $this->render('training_plan/about_me/about_me_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function command(File $photo, AboutMe $aboutMe): void
    {
        $message = new AboutMeCreationMessage($photo, $aboutMe);
        $this->commandBus->dispatch($message);
    }
}