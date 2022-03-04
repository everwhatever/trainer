<?php

declare(strict_types=1);

namespace App\TrainingPlan\UI\Controller\AboutMe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    /**
     * @Route("/about-me/display", name="about_me_display")
     */
    public function displayAction()
    {
        echo "sad";
    }
}