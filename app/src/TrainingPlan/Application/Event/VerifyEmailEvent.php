<?php

declare(strict_types=1);

namespace App\TrainingPlan\Application\Event;

use Symfony\Contracts\EventDispatcher\Event;

class VerifyEmailEvent extends Event
{
    public const NAME = 'user.email_verified';

    private string $userEmail;

    private string $userId;

    public function __construct(string $userEmail, string $userId)
    {
        $this->userEmail = $userEmail;
        $this->userId = $userId;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
