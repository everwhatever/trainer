<?php

declare(strict_types=1);

namespace App\User\Application\Message\Command;

class EmailVerificationMessage
{
    public function __construct(private readonly string $requestUri, private readonly string $userId, private readonly string $userEmail)
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
