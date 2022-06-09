<?php

declare(strict_types=1);

namespace App\User\Application\Event;

use Symfony\Contracts\EventDispatcher\Event;

class VerifyEmailEvent extends Event
{
    public const NAME = 'user.email_verified';

    public function __construct(private string $userEmail, private string $userId)
    {
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
