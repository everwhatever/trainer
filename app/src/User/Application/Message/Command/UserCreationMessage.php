<?php

namespace App\User\Application\Message\Command;

class UserCreationMessage
{
    public function __construct(private readonly string $email, private readonly string $plainPassword, private $role)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
