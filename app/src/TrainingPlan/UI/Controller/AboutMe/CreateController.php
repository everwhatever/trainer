<?php

declare(strict_types=1);

namespace App\TrainingPlan\UI\Controller\AboutMe;

use App\TrainingPlan\Application\Message\Command\AboutMeCreationMessage;
use App\TrainingPlan\Application\Message\Command\UserCreationMessage;
use App\TrainingPlan\Infrastructure\Form\AboutMeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }


    /**
     * @Route("/about-me/create", name="aboute_me_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function createAction(Request $request): Response
    {
        $form = $this->createForm(AboutMeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $this->command($form->get('photo')->getData(), $formData['title'], $formData['description']);

            return $this->redirectToRoute('about_me_display');
        }

        return $this->render('training_plan/about_me/about_me_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function command(File $photo, string $title, string $description): void
    {
        $message = new AboutMeCreationMessage($photo, $title, $description);
        $this->commandBus->dispatch($message);
    }
}