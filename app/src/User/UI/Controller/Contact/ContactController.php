<?php

declare(strict_types=1);

namespace App\User\UI\Controller\Contact;

use App\User\Application\Message\Command\ContactMessage;
use App\User\Infrastructure\Form\Contact\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    #[Route(path: '/contact', name: 'app_contact')]
    public function sendContactEmail(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            try {
                $this->command($data);
                $this->addFlash('success', 'Wysłano emaila');

                return $this->redirectToRoute('homepage');
            } catch (Exception) {
                $this->addFlash('error', 'Nie wysłano emaila');

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('user/contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function command(array $data): void
    {
        $message = new ContactMessage($data);
        $this->commandBus->dispatch($message);
    }
}
