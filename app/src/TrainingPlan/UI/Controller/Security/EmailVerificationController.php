<?php

declare(strict_types=1);

namespace App\TrainingPlan\UI\Controller\Security;

use App\TrainingPlan\Application\Message\Command\EmailVerificationMessage;
use App\TrainingPlan\Domain\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class EmailVerificationController extends AbstractController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus,)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/verify", name="registration_confirmation_route")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var User $user */
        $user = $this->getUser();

        $this->verifyEmailCommand($request->getUri(), (string) $user->getId(), $user->getEmail());

        $this->addFlash('success', 'Weryfikacja przebiegła poprawnie.');

        return $this->redirectToRoute('homepage');
    }

    private function verifyEmailCommand(string $requestUri, string $userId, string $userEmail): void
    {
        $message = new EmailVerificationMessage($requestUri, $userId, $userEmail);
        $this->commandBus->dispatch($message);
    }
}
