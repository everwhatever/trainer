<?php

declare(strict_types=1);

namespace App\User\UI\Controller\Security;

use App\User\Application\Message\Command\UserCreationMessage;
use App\User\Domain\Model\User;
use App\User\Infrastructure\Form\Security\RegisterType;
use App\User\Infrastructure\Security\SecurityAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    private MessageBusInterface $commandBus;

    private UserAuthenticatorInterface $authenticator;

    private SecurityAuthenticator $securityAuthenticator;

    public function __construct(MessageBusInterface $commandBus,
                                UserAuthenticatorInterface $authenticator,
                                SecurityAuthenticator $securityAuthenticator,
    ) {
        $this->commandBus = $commandBus;
        $this->authenticator = $authenticator;
        $this->securityAuthenticator = $securityAuthenticator;
    }

    #[Route(path: '/register', name: 'register')]
    public function registerAction(Request $request): Response
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->registerCommand($form->getData()['email'], $form->get('plainPassword')->getData());

            return $this->authenticator->authenticateUser(
                $user,
                $this->securityAuthenticator,
                $request
            );
        }

        return $this->render('user/security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/register/admin', name: 'register_admin')]
    public function registerAdminAction(Request $request): Response
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->registerCommand($form->getData()['email'], $form->get('plainPassword')->getData(), 'ROLE_ADMIN');

            return $this->authenticator->authenticateUser(
                $user,
                $this->securityAuthenticator,
                $request
            );
        }

        return $this->render('user/security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function registerCommand(string $email, string $plainPassword, ?string $role = 'ROLE_USER'): User
    {
        $message = new UserCreationMessage($email, $plainPassword, $role);
        $envelope = $this->commandBus->dispatch($message);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        return $handledStamp->getResult();
    }
}
