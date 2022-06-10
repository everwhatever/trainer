<?php

declare(strict_types=1);

namespace App\User\Application\Message\Command;

class EmailVerificationMessage
{
    public function __construct(public readonly string $requestUri, public readonly string $userId, public readonly string $userEmail)
    {
    }
}
