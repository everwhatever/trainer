<?php

namespace App\TrainingPlan\Application\Event;

class VerifyEmailEvent
{
    public const NAME = 'verify_email';

    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}