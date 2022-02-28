<?php

namespace App\TrainingPlan\Application\Message\Command;

class UserCreationMessage
{
    private string $email;

    private string $plainPassword;

    private string $role;

    public function __construct(string $email, string $plainPassword, $role)
    {
        $this->email = $email;
        $this->plainPassword = $plainPassword;
        $this->role = $role;
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
