<?php

declare(strict_types=1);

namespace App\User\Application\Message\Command;

class EmailVerificationMessage
{
    public function __construct(private string $requestUri, private string $userId, private string $userEmail)
    {
    }

    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }
}
