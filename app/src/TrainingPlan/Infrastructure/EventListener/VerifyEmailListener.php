<?php

namespace App\TrainingPlan\Infrastructure\EventListener;

use App\TrainingPlan\Application\Event\VerifyEmailEvent;

class VerifyEmailListener
{
    public function verifyEmail(VerifyEmailEvent $event)
    {
        die("now");
    }
}