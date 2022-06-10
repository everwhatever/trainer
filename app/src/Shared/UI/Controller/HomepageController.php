<?php

namespace App\Shared\UI\Controller;

use App\Product\Domain\Model\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly string $shortPhotoDir)
    {
    }

    #[Route(path: '/', name: 'homepage')]
    public function indexAction(): Response
    {
        $offers = $this->entityManager->getRepository(Offer::class)->findAll();

        return $this->render('shared/homepage.html.twig', [
            'offers' => $offers,
            'photo_dir' => $this->shortPhotoDir,
        ]);
    }
}
