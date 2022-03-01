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
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class RegistrationController extends AbstractController
{
    private MessageBusInterface $commandBus;

    private UserAuthenticatorInterface $authenticator;

    private SecurityAuthenticator $securityAuthenticator;

    private VerifyEmailHelperInterface $verifyEmailHelper;

    public function __construct(MessageBusInterface        $commandBus,
                                UserAuthenticatorInterface $authenticator,
                                SecurityAuthenticator      $securityAuthenticator,
                                VerifyEmailHelperInterface $verifyEmailHelper
    )
    {
        $this->commandBus = $commandBus;
        $this->authenticator = $authenticator;
        $this->securityAuthenticator = $securityAuthenticator;
        $this->verifyEmailHelper = $verifyEmailHelper;
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

    /**
     * @Route("/verify", name="registration_confirmation_route")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        try {
            $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());
        } catch (VerifyEmailExceptionInterface $e) {
            $this->addFlash('verify_email_error', $e->getReason());

            return $this->redirectToRoute('register');
        }

        // TODO: Mark your user as verified. e.g. switch a User::verified property to true

        $this->addFlash('success', 'Your e-mail address has been verified.');

        return $this->redirectToRoute('homepage');
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
