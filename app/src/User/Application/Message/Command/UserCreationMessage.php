<?php

namespace App\User\Application\Message\Command;

class UserCreationMessage
{
    public function __construct(public readonly string $email,
                                public readonly string $plainPassword, public readonly string $role)
    {
    }
}
