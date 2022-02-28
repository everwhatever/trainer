<?php

namespace App\TrainingPlan\UI\Controller;

use App\TrainingPlan\Application\Message\Command\UserCreationMessage;
use App\TrainingPlan\Domain\Model\User;
use App\TrainingPlan\Infrastructure\Form\RegisterType;
use App\TrainingPlan\Infrastructure\Security\SecurityAuthenticator;
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

    public function __construct(MessageBusInterface        $commandBus,
                                UserAuthenticatorInterface $authenticator,
                                SecurityAuthenticator      $securityAuthenticator
    )
    {
        $this->commandBus = $commandBus;
        $this->authenticator = $authenticator;
        $this->securityAuthenticator = $securityAuthenticator;
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request): Response
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->command($form->getData()['email'], $form->get('plainPassword')->getData());

            return $this->authenticator->authenticateUser(
                $user,
                $this->securityAuthenticator,
                $request
            );
        }

        return $this->render('training_plan/security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/register/admin", name="register_admin")
     */
    public function registerAdminAction(Request $request): Response
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->command($form->getData()['email'], $form->get('plainPassword')->getData(), 'ROLE_ADMIN');

            return $this->authenticator->authenticateUser(
                $user,
                $this->securityAuthenticator,
                $request
            );
        }

        return $this->render('training_plan/security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function command(string $email, string $plainPassword, ?string $role = 'ROLE_USER'): User
    {
        $message = new UserCreationMessage($email, $plainPassword, $role);
        $envelope = $this->commandBus->dispatch($message);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        return $handledStamp->getResult();
    }
}
