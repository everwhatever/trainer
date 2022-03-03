<?php

declare(strict_types=1);

namespace App\TrainingPlan\Application\Handler\Command;

use App\TrainingPlan\Application\Message\Command\EmailVerificationMessage;
use App\TrainingPlan\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\WrongEmailVerifyException;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerificationHandler implements MessageHandlerInterface
{
    private VerifyEmailHelperInterface $verifyEmailHelper;

    private EntityManagerInterface $entityManager;

    public function __construct(VerifyEmailHelperInterface $verifyEmailHelper, EntityManagerInterface $entityManager)
    {
        $this->verifyEmailHelper = $verifyEmailHelper;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function __invoke(EmailVerificationMessage $message): void
    {
        $userId = $message->getUserId();

        $this->validateEmail($message);

        $this->verifyUser($userId);
    }

    /**
     * @throws VerifyEmailExceptionInterface
     * @throws Exception
     */
    private function validateEmail(EmailVerificationMessage $message): void
    {
        try {
            $this->verifyEmailHelper->validateEmailConfirmation($message->getRequestUri(),
                $message->getUserId(),
                $message->getUserEmail());
        } catch (WrongEmailVerifyException $exception) {
            throw $exception->getReason();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function verifyUser(string $userId): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);
        $user->setVerified(true);
    }
}
