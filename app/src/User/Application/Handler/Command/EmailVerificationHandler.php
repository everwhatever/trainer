<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\User\Application\Message\Command\EmailVerificationMessage;
use App\User\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\WrongEmailVerifyException;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerificationHandler implements MessageHandlerInterface
{
    public function __construct(private readonly VerifyEmailHelperInterface $verifyEmailHelper, private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function __invoke(EmailVerificationMessage $message): void
    {
        $userId = $message->userId;

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
            $this->verifyEmailHelper->validateEmailConfirmation($message->requestUri,
                $message->userId,
                $message->userEmail);
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
