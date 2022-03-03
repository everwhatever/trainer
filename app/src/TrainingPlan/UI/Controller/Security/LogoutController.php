<?php

declare(strict_types=1);

namespace App\TrainingPlan\UI\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController
{
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
    }
}