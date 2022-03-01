<?php

declare(strict_types=1);

namespace App\TrainingPlan\Infrastructure\EventSubscriber;

use App\TrainingPlan\Application\Event\VerifyEmailEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Model\VerifyEmailSignatureComponents;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class VerifyEmailSubscriber implements EventSubscriberInterface
{
    private VerifyEmailHelperInterface $verifyEmailHelper;

    private MailerInterface $mailer;

    public function __construct(VerifyEmailHelperInterface $verifyEmailHelper,
                                MailerInterface            $mailer)
    {
        $this->verifyEmailHelper = $verifyEmailHelper;
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function verifyEmail(VerifyEmailEvent $event): void
    {
        $userEmail = $event->getUserEmail();
        $userId = $event->getUserId();

        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'registration_confirmation_route',
            $userId,
            $userEmail
        );

        $email = $this->prepareEmailTemplate($userEmail, $signatureComponents);

        $this->mailer->send($email);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            VerifyEmailEvent::NAME => 'verifyEmail'
        ];
    }

    private function prepareEmailTemplate(string $userEmail, VerifyEmailSignatureComponents $signatureComponents): TemplatedEmail
    {
        $email = new TemplatedEmail();
        $email->from('koszykarz.kuba@gmail.com');
        $email->to($userEmail);
        $email->htmlTemplate('security/confirmation_email.html.twig');
        $email->context(['signedUrl' => $signatureComponents->getSignedUrl()]);

        return $email;
    }
}