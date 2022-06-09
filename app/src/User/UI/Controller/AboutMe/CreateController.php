<?php

declare(strict_types=1);

namespace App\User\UI\Controller\AboutMe;

use App\User\Application\Message\Command\AboutMeCreationMessage;
use App\User\Domain\Model\AboutMe;
use App\User\Infrastructure\Form\AboutMeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    #[Route(path: '/about-me/create', name: 'aboute_me_create')]
    #[IsGranted('ROLE_ADMIN')]
    public function createAction(Request $request): Response
    {
        $form = $this->createForm(AboutMeType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $aboutMe = $form->getData();
            $this->command($form->get('photo')->getData(), $aboutMe);

            return $this->redirectToRoute('about_me_display_one');
        }

        return $this->render('user/about_me/about_me_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function command(File $photo, AboutMe $aboutMe): void
    {
        $message = new AboutMeCreationMessage($photo, $aboutMe);
        $this->commandBus->dispatch($message);
    }
}
